<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_by',
        'is_active',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function residences(): HasMany
    {
        return $this->hasMany(Residence::class, 'city_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'city_id');
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }
}
