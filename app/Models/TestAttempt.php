<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\HasOne;

class TestAttempt extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'job_application_id',
        'test_id',
        'started_at',
        'finished_at',
        'duration',
        'objective_score',
        'essay_score',
        'total_score',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function jobApplication(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class, 'attempt_id');
    }

    public function discTestResult(): HasOne
    {
        return $this->hasOne(DiscTestResult::class, 'test_attempt_id');
    }
}
