<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'name',
        'scale',
        'month',
        'year',
        'description',
        'certificate_path',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }

    public function applicantProfile(): BelongsTo
    {
        return $this->belongsTo(ApplicantProfile::class, 'profile_id');
    }
}
