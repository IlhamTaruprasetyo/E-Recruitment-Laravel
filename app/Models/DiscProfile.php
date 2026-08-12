<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'pattern_code',
        'title',
        'general_description',
    ];

    public function testResults(): HasMany
    {
        return $this->hasMany(DiscTestResult::class, 'disc_profiles_id');
    }
}
