<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    public $timestamps = false;

    protected $fillable = ['job_id', 'profile_id', 'status', 'applied_at', 'notes'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class, 'profile_id');
    }

    public function statusHistories()
    {
        return $this->hasMany(ApplicationStatusHistory::class, 'job_applications_id');
    }

    public function interviewSchedules()
    {
        return $this->hasMany(InterviewSchedule::class, 'job_applications_id');
    }
}
