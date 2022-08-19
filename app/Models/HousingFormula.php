<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HousingFormula extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_by',
        'is_active',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(HousingPrice::class, 'housing_formula_id');
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }
}
