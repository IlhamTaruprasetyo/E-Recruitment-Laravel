<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'company_id', 'department_id', 'title', 'description', 
        'employment_type', 'location', 'salary_min', 'salary_max', 
        'quota', 'deadline', 'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function degrees()
    {
        return $this->belongsToMany(Degree::class, 'job_degrees');
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'job_majors');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'job_id');
    }
}
