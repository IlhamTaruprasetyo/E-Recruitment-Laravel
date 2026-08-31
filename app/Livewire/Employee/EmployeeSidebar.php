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

        // Hitung tes yang tersedia untuk karyawan ini (berdasarkan departemennya atau umum)
        $availableTestsCount = 0;
        if ($employeeProfile) {
            $availableTestsCount = Test::where('test_type', 'employee')
                ->where(function ($query) use ($employeeProfile) {
                    if ($employeeProfile->department_id) {
                        $query->where('department_id', $employeeProfile->department_id)
                              ->orWhereNull('department_id');
                    } else {
                        $query->whereNull('department_id');
                    }
                })
                ->count();
        }

        // Hitung riwayat pengerjaan asesmen yang sudah selesai
        $completedAttemptsCount = 0;
        if ($user) {
            $completedAttemptsCount = TestAttempt::where('user_id', $user->id)
                ->whereNotNull('finished_at')
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
