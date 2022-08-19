<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResidenceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_by',
        'is_active',
    ];

    public function residences(): HasMany
    {
        return $this->hasMany(Residence::class, 'residence_category_id');
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }
}
