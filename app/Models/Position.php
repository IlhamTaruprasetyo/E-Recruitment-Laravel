<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'department_id',
        'name',
        'description',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function employeeProfiles(): HasMany
    {
        return $this->hasMany(EmployeeProfile::class);
    }

    /**
     * Get cached list of all positions with department.
     */
    public static function cachedAll()
    {
        return \Illuminate\Support\Facades\Cache::remember('master_positions_all', 86400, function () {
            return static::with('department.company')->orderBy('name', 'asc')->get();
        });
    }
}
