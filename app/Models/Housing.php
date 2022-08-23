<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Housing extends Model
{
    use HasFactory;

    protected $fillable = [
        'residence_id',
        'housing_category_id',
        'name',
        'description',
        'for_max',
        'order_by',
        'is_active',
    ];

    public function residence(): BelongsTo
    {
        return $this->belongsTo(Residence::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HousingCategory::class, 'housing_category_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(HousingPrice::class, 'housing_id');
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }
}
