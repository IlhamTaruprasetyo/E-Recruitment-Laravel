<?php

namespace App\Livewire\Employee;

use App\Models\Test;
use App\Models\TestAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EmployeeSidebar extends Component
{
    public $activeTab = 'dashboard';

    protected $listeners = ['profile-updated' => '$refresh'];

    public function mount($activeTab = 'dashboard')
    {
        $this->activeTab = $activeTab;
    }

    public function render()
    {
        $user = Auth::user();
        $employeeProfile = $user?->employeeProfile()->with(['company', 'department.company'])->first();

        // Hitung tes yang tersedia untuk karyawan ini (sesuai departemen, umum, & target tipe pegawai)
        $availableTestsCount = 0;
        if ($employeeProfile) {
            $userType = $employeeProfile->employee_type ?: 'permanent';

            $availableTestsCount = Test::where('test_type', 'employee')
                ->where(function ($query) use ($employeeProfile) {
                    $query->where(function ($general) {
                        $general->whereDoesntHave('departments')
                                ->whereNull('department_id');
                    });

                    if ($employeeProfile->department_id) {
                        $query->orWhereHas('departments', function ($q) use ($employeeProfile) {
                            $q->where('departments.id', $employeeProfile->department_id);
                        })->orWhere('department_id', $employeeProfile->department_id);
                    }
                })
                ->where(function ($query) use ($userType) {
                    $query->whereNull('target_employee_type')
                          ->orWhere('target_employee_type', 'all')
                          ->orWhere('target_employee_type', $userType);
                })
                ->count();
        }

        // Hitung riwayat pengerjaan asesmen yang sudah selesai
        $completedAttemptsCount = 0;
        if ($user) {
            $completedAttemptsCount = TestAttempt::where('user_id', $user->id)
                ->where('attempt_type', 'employee')
                ->where('status', '!=', 'in_progress')
                ->count();
        }

        return view('components.sidebar.employee-sidebar', [
            'user' => $user,
            'employeeProfile' => $employeeProfile,
            'availableTestsCount' => $availableTestsCount,
            'completedAttemptsCount' => $completedAttemptsCount,
        ]);
    }
}
