<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewSchedule extends Model
{
    protected $table = 'interview_schedule';
    public $timestamps = false;

    protected $fillable = [
        'job_applications_id',
        'users_id',
        'interview_date',
        'location',
        'meeting_link',
        'status',
    ];

    protected $casts = [
        'interview_date' => 'datetime',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class, 'job_applications_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Check if the interview is scheduled online
     */
    public function getIsOnlineAttribute(): bool
    {
        return !empty($this->meeting_link) || str_contains(strtolower($this->location ?? ''), 'online');
    }
}
