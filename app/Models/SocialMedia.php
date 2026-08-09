<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMedia extends Model
{
    public $timestamps = false;
    protected $table = 'social_medias'; // Memastikan nama tabel sesuai db

    protected $fillable = [
        'profile_id',
        'platform_name',
        'url',
    ];

    public function applicantProfile(): BelongsTo
    {
        return $this->belongsTo(ApplicantProfile::class, 'profile_id');
    }
}
