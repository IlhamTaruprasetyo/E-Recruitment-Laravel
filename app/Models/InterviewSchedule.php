<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewSchedule extends Model
{
    protected $table = 'interview_schedule';
    protected $fillable = ['job_applications_id', 'users_id', 'interview_date', 'location', 'meeting_link', 'status'];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class, 'job_applications_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
