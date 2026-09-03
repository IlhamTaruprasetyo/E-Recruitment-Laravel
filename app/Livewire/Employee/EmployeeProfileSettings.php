<?php

namespace App\Livewire\Employee;

use App\Models\Company;
use App\Models\Department;
use App\Models\EmployeeProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmployeeProfileSettings extends Component
{
    use WithFileUploads;

    public $nik;

    public $full_name;

    public $company_id;

    public $department_id;

    public $position_title;

    public $employee_type = 'permanent';

    public $photo;

    public $cropped_photo_base64;

    public $current_photo_url;

    public function mount(): void
    {
        $user = Auth::user();
        $profile = EmployeeProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $user->name,
                'nik' => $user->nik,
            ]
        );

        $this->nik = $profile->nik ?? $user->nik;
        $this->full_name = $profile->full_name ?? $user->name;
        $this->company_id = $profile->company_id;
        $this->department_id = $profile->department_id;
        $this->position_title = $profile->position_title;
        $this->employee_type = $profile->employee_type ?? 'permanent';
        $this->current_photo_url = $profile->photo
            ? asset('storage/' . $profile->photo) . '?v=' . time()
            : null;
    }

    public function updatedCompanyId(): void
    {
        if ($this->department_id) {
            $department = Department::find($this->department_id);
            if (! $department || (string) $department->company_id !== (string) $this->company_id) {
                $this->department_id = null;
            }
        }
    }

    public function updatedDepartmentId(): void
    {
        if ($this->department_id) {
            $department = Department::find($this->department_id);
            if ($department?->company_id) {
                $this->company_id = $department->company_id;
            }
        }
    }

    protected function rules(): array
    {
        $user = Auth::user();
        $profile = EmployeeProfile::where('user_id', $user->id)->first();

        return [
            'nik' => [
                'nullable',
                'digits:16',
                Rule::unique('employee_profiles', 'nik')->ignore($profile?->id),
                Rule::unique('users', 'nik')->ignore($user->id),
            ],
            'full_name' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'position_title' => 'nullable|string|max:255',
            'employee_type' => 'required|in:permanent,contract,internship,probation',
            'photo' => 'nullable|image|max:5120',
        ];
    }

    protected function messages(): array
    {
        return [
            'nik.digits' => 'NIK harus berupa 16 digit angka.',
            'nik.unique' => 'NIK sudah digunakan oleh pengguna lain.',
        ];
    }

    public function save(): void
    {
        $this->company_id = $this->company_id ?: null;
        $this->department_id = $this->department_id ?: null;

        $validatedData = $this->validate();

        $user = Auth::user();
        $profile = EmployeeProfile::firstOrCreate(['user_id' => $user->id]);

        if ($this->cropped_photo_base64) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }

            $imageParts = explode(';base64,', $this->cropped_photo_base64);
            $imageTypeAux = explode('image/', $imageParts[0]);
            $imageType = isset($imageTypeAux[1]) ? strtolower($imageTypeAux[1]) : 'jpeg';
            if ($imageType === 'jpeg') {
                $imageType = 'jpg';
            }
            $imageBase64 = base64_decode($imageParts[1]);

            $fileName = 'employee-photos/' . uniqid() . '.' . $imageType;
            Storage::disk('public')->put($fileName, $imageBase64);

            $validatedData['photo'] = $fileName;
            $this->current_photo_url = asset('storage/' . $fileName) . '?v=' . time();
            $this->photo = null;
            $this->cropped_photo_base64 = null;
        } elseif ($this->photo) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }
            $photoPath = $this->photo->store('employee-photos', 'public');
            $validatedData['photo'] = $photoPath;
            $this->current_photo_url = asset('storage/' . $photoPath) . '?v=' . time();
            $this->photo = null;
        } else {
            unset($validatedData['photo']);
        }

        if ($this->department_id && empty($this->company_id)) {
            $department = Department::find($this->department_id);
            if ($department?->company_id) {
                $validatedData['company_id'] = $department->company_id;
            }
        }

        $profile->update($validatedData);

        if ($user->name !== $this->full_name || $user->nik !== $this->nik) {
            $user->update([
                'name' => $this->full_name,
                'nik' => $this->nik,
            ]);
        }

        session()->flash('employee_profile_message', 'Profil karyawan berhasil diperbarui.');
        $this->dispatch('profile-updated', name: $this->full_name);
    }

    public function render()
    {
        $companies = Company::orderBy('name')->get();
        $departments = Department::with('company')
            ->when($this->company_id, fn ($query) => $query->where('company_id', $this->company_id))
            ->orderBy('name')
            ->get();

        return view('livewire.employee.employee-profile-settings', [
            'companies' => $companies,
            'departments' => $departments,
        ]);
    }
}
