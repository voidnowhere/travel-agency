<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function residences(): HasManyThrough
    {
        return $this->hasManyThrough(Residence::class, City::class);
    }
}
