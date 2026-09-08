<?php

namespace App\Observers;

use App\Models\Department;
use Illuminate\Support\Facades\Cache;

class DepartmentObserver
{
    /**
     * Clear department related cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('master_departments_all');
        Cache::forget('frontend_footer_departments');
        Cache::forget('home_departments_count');
        Cache::forget('home_departments_with_jobs');
        Cache::forget('about_departments_with_jobs');
    }

    public function saved(Department $department): void
    {
        $this->clearCache();
    }

    public function deleted(Department $department): void
    {
        $this->clearCache();
    }
}
