<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscTrait extends Model
{
    use HasFactory;

    protected $fillable = [
        'dimension_code',
        'potret_diri',
        'kelebihan',
        'kekurangan',
        'deskripsi_tipe',
        'kecenderungan',
        'lingkungan_cocok',
    ];

    protected $casts = [
        'potret_diri' => 'array',
        'kelebihan' => 'array',
        'kekurangan' => 'array',
        'kecenderungan' => 'array',
        'lingkungan_cocok' => 'array',
    ];
}
