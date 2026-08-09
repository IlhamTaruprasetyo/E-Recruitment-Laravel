<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organization extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'name',
        'position',
        'description',
        'is_active',
        'start_month',
        'start_year',
        'end_month',
        'end_year',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'start_year' => 'integer',
            'end_year' => 'integer',
        ];
    }

    public function applicantProfile(): BelongsTo
    {
        return $this->belongsTo(ApplicantProfile::class, 'profile_id');
    }
}
