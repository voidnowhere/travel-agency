<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HousingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_by',
        'is_active',
    ];

    public function housings(): HasMany
    {
        return $this->hasMany(Housing::class, 'housing_category_id');
    }
}
