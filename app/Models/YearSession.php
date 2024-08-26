<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class);
    }
}
