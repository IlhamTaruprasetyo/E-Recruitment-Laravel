<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeProfile;
use App\Models\Department;

class EmployeeTable extends Component
{
    use WithPagination;

    public $search = '';
    public $departmentId = '';
    public $employeeType = '';
    public $perPage = 10;

    // Modal Edit State
    public $showEditModal = false;
    public $editId = null;
    public $editFullName = '';
    public $editNik = '';
    public $editEmployeeType = 'permanent';
    public $editDepartmentId = '';
    public $editPositionTitle = '';

    // Modal Double Permission Promosi State
    public $showPromoteModal = false;
    public $promoteId = null;
    public $promoteFullName = '';
    public $promoteCurrentPosition = '';
    public $promoteNewPosition = '';
    public $promoteTargetType = 'permanent';
    public $promoteDepartmentId = '';
    public $promoteDepartmentName = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartmentId()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingEmployeeType()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->departmentId = '';
        $this->employeeType = '';
        $this->resetPage();
    }

    public function openEdit($id)
    {
        $employee = EmployeeProfile::with('user')->findOrFail($id);
        $this->editId = $employee->id;
        $this->editFullName = $employee->full_name ?? ($employee->user?->name ?? '');
        $this->editNik = $employee->nik ?? ($employee->user?->nik ?? '');
        $this->editEmployeeType = $employee->employee_type ?? 'permanent';
        $this->editDepartmentId = $employee->department_id;
        $this->editPositionTitle = $employee->position_title ?? '';
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['editId', 'editFullName', 'editNik', 'editEmployeeType', 'editDepartmentId', 'editPositionTitle']);
    }

    public function saveEmployee()
    {
        $this->validate([
            'editFullName' => 'required|string|max:255',
            'editEmployeeType' => 'required|in:permanent,contract,internship,probation',
            'editDepartmentId' => 'nullable|exists:departments,id',
            'editPositionTitle' => 'nullable|string|max:255',
        ]);

        $employee = EmployeeProfile::findOrFail($this->editId);
        $dept = $this->editDepartmentId ? Department::find($this->editDepartmentId) : null;

        $employee->update([
            'full_name' => $this->editFullName,
            'employee_type' => $this->editEmployeeType,
            'department_id' => $this->editDepartmentId ?: null,
            'company_id' => $dept?->company_id ?? $employee->company_id,
            'position_title' => $this->editPositionTitle ?: null,
        ]);

        if ($employee->user && $employee->user->name !== $this->editFullName) {
            $employee->user->update(['name' => $this->editFullName]);
        }

        $this->closeEditModal();
        session()->flash('message', 'Data dan status pegawai berhasil diperbarui.');
    }

    public function openPromoteModal($id)
    {
        $employee = EmployeeProfile::with(['user', 'department'])->findOrFail($id);
        $this->promoteId = $employee->id;
        $this->promoteFullName = $employee->full_name ?? ($employee->user?->name ?? 'Peserta Magang');
        $this->promoteCurrentPosition = $employee->position_title ?? 'Intern / Magang';
        $this->promoteNewPosition = $employee->position_title ? str_ireplace(['intern', 'magang', 'internship'], 'Staff', $employee->position_title) : 'Staff';
        $this->promoteDepartmentId = $employee->department_id;
        $this->promoteDepartmentName = $employee->department?->name ?? 'Belum Diatur';
        $this->promoteTargetType = 'permanent';
        $this->showPromoteModal = true;
    }

    public function closePromoteModal()
    {
        $this->showPromoteModal = false;
        $this->reset(['promoteId', 'promoteFullName', 'promoteCurrentPosition', 'promoteNewPosition', 'promoteTargetType', 'promoteDepartmentId', 'promoteDepartmentName']);
    }

    public function confirmPromotion()
    {
        $this->validate([
            'promoteTargetType' => 'required|in:permanent,contract',
            'promoteNewPosition' => 'required|string|max:255',
            'promoteDepartmentId' => 'nullable|exists:departments,id',
        ]);

        $employee = EmployeeProfile::findOrFail($this->promoteId);
        $dept = $this->promoteDepartmentId ? Department::find($this->promoteDepartmentId) : null;

        $employee->update([
            'employee_type' => $this->promoteTargetType,
            'position_title' => $this->promoteNewPosition,
            'department_id' => $this->promoteDepartmentId ?: $employee->department_id,
            'company_id' => $dept?->company_id ?? $employee->company_id,
        ]);

        $statusText = $this->promoteTargetType === 'permanent' ? 'Karyawan Tetap' : 'Karyawan Kontrak';
        $this->closePromoteModal();
        session()->flash('message', 'Selamat! ' . $employee->full_name . ' berhasil diangkat menjadi ' . $statusText . ' dengan jabatan "' . $this->promoteNewPosition . '".');
    }

    public function render()
    {
        $departments = Department::with('company')->orderBy('name', 'asc')->get();

        $employees = EmployeeProfile::with(['user', 'department.company'])
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(full_name) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(position_title) LIKE ?', ['%' . $search . '%'])
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->whereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
                      });
                });
            })
            ->when($this->departmentId, function ($query) {
                $query->where('department_id', $this->departmentId);
            })
            ->when($this->employeeType, function ($query) {
                $query->where('employee_type', $this->employeeType);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.employee.table', [
            'employees' => $employees,
            'departments' => $departments,
        ]);
    }
}
