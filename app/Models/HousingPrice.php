<?php

namespace App\Models;

use App\Helpers\WeekdayHelper;
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
        'extra_price',
        'extra_price_is_active',
        'min_nights',
        'weekends',
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

    public function weekendsNames(): string
    {
        return implode(',', array_map(function ($day) {
            return WeekdayHelper::$weekdays[$day];
        }, explode(',', $this->weekends)));
    }

    public function weekendsArray(): array
    {
        return explode(',', $this->weekends);
    }
}
