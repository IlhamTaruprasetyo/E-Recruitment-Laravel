<?php

namespace App\Observers;

use App\Models\Job;
use Illuminate\Support\Facades\Cache;

class JobObserver
{
    /**
     * Clear job related home & frontend cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('home_total_jobs_count');
        Cache::forget('home_total_quota_count');
        Cache::forget('home_featured_jobs');
        Cache::forget('home_departments_with_jobs');
        Cache::forget('companies_with_jobs');
        Cache::forget('about_departments_with_jobs');
        Cache::forget('frontend_footer_departments');
    }

    public function saved(Job $job): void
    {
        $this->clearCache();
    }

    public function deleted(Job $job): void
    {
        $this->clearCache();
    }
}
