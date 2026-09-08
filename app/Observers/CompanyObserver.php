<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class CompanyObserver
{
    /**
     * Clear company related cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('frontend_main_company');
        Cache::forget('master_companies_all');
        Cache::forget('home_companies_count');
        Cache::forget('about_group_companies');
        Cache::forget('companies_with_jobs');
    }

    public function saved(Company $company): void
    {
        $this->clearCache();
    }

    public function deleted(Company $company): void
    {
        $this->clearCache();
    }
}
