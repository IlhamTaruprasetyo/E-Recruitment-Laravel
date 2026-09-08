<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    protected $fillable = ['company_id', 'name', 'description'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'department_test', 'department_id', 'test_id')
                    ->withTimestamps();
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    /**
     * Get cached list of all departments.
     */
    public static function cachedAll()
    {
        return \Illuminate\Support\Facades\Cache::remember('master_departments_all', 86400, function () {
            return static::with('company')->orderBy('name', 'asc')->get();
        });
    }
}
