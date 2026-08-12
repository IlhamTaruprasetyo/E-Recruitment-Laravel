<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscNorm extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_type',
        'attribute',
        'raw_score',
        'converted_score',
    ];
}
