<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Test;
use App\Models\TestAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class EmployeeAssessmentPortal extends Component
{
    #[On('profile-updated')]
    public function refreshPortal(): void
    {
        // Re-render after profile update
    }

    public function render()
    {
        $user = Auth::user();
        $employeeProfile = $user?->employeeProfile()->with(['company', 'department.company'])->first();

        // 1. Ambil paket tes asesmen yang tersedia untuk karyawan ini (sesuai departemen, umum, & target tipe pegawai)
        $tests = collect();
        if ($employeeProfile) {
            $userType = $employeeProfile->employee_type ?: 'permanent';

            $tests = Test::with(['category', 'departments', 'department', 'questions'])
                ->where('test_type', 'employee')
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
                ->orderBy('id', 'desc')
                ->get();
        }

        // 2. Ambil riwayat pengerjaan tes milik user ini
        $attempts = TestAttempt::with(['test.category', 'test.department', 'discTestResult.discProfile'])
            ->where('user_id', $user->id)
            ->where('attempt_type', 'employee')
            ->orderBy('id', 'desc')
            ->get();

        // Buat map test_id -> attempt terakhir untuk mengecek status pengerjaan masing-masing tes
        $attemptsByTestId = $attempts->keyBy('test_id');

        return view('livewire.employee.assessment-portal', [
            'user' => $user,
            'employeeProfile' => $employeeProfile,
            'tests' => $tests,
            'attempts' => $attempts,
            'attemptsByTestId' => $attemptsByTestId,
        ]);
    }
}
