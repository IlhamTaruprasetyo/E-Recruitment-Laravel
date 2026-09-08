<?php

namespace App\Observers;

use App\Models\Degree;
use Illuminate\Support\Facades\Cache;

class DegreeObserver
{
    /**
     * Clear degree related cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('master_degrees_all');
        Cache::forget('master_degrees_ordered');
    }

    public function saved(Degree $degree): void
    {
        $this->clearCache();
    }

    public function deleted(Degree $degree): void
    {
        $this->clearCache();
    }
}
