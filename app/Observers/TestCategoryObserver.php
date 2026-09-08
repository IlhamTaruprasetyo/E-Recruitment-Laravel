<?php

namespace App\Observers;

use App\Models\TestCategory;
use Illuminate\Support\Facades\Cache;

class TestCategoryObserver
{
    /**
     * Clear test category related cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('master_test_categories_all');
    }

    public function saved(TestCategory $category): void
    {
        $this->clearCache();
    }

    public function deleted(TestCategory $category): void
    {
        $this->clearCache();
    }
}
