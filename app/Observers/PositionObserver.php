<?php

namespace App\Observers;

use App\Models\Position;
use Illuminate\Support\Facades\Cache;

class PositionObserver
{
    /**
     * Clear position related cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('master_positions_all');
        Cache::forget('master_positions_with_dept');
    }

    public function saved(Position $position): void
    {
        $this->clearCache();
    }

    public function deleted(Position $position): void
    {
        $this->clearCache();
    }
}
