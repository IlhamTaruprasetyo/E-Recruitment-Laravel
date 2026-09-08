<?php

namespace App\Observers;

use App\Models\Major;
use Illuminate\Support\Facades\Cache;

class MajorObserver
{
    /**
     * Clear major related cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('master_majors_all');
        Cache::forget('master_majors_ordered');
    }

    public function saved(Major $major): void
    {
        $this->clearCache();
    }

    public function deleted(Major $major): void
    {
        $this->clearCache();
    }
}
