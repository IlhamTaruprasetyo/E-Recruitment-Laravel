<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatusHistory extends Model
{
    protected $table = 'application_status_history';
    protected $fillable = ['job_applications_id', 'status', 'notes', 'changed_by', 'changed_at'];
    public $timestamps = false; // Menggunakan changed_at sesuai skema

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class, 'job_applications_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
