<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionBank::class, 'category_id');
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class, 'category_id');
    }
}
