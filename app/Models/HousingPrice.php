<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HousingPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'housing_id',
        'housing_formula_id',
        'type_SHML',
        'for_one_price',
        'for_one_extra_price',
        'min_nights',
        'weekend_price',
        'weekend_is_active',
        'kid_bed_price',
        'kid_bed_is_active',
        'extra_bed_price',
        'extra_bed_is_active',
    ];

    public function housing(): BelongsTo
    {
        return $this->belongsTo(Housing::class);
    }

    public function formula(): BelongsTo
    {
        return $this->belongsTo(HousingFormula::class, 'housing_formula_id');
    }
}
