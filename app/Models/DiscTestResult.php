<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_attempt_id',
        'disc_profiles_id',
        'line_1_scores',
        'line_2_scores',
        'line_3_scores',
    ];

    protected $casts = [
        'line_1_scores' => 'array',
        'line_2_scores' => 'array',
        'line_3_scores' => 'array',
    ];

    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class, 'test_attempt_id');
    }

    public function discProfile(): BelongsTo
    {
        return $this->belongsTo(DiscProfile::class, 'disc_profiles_id');
    }
}
