<?php

namespace App\Models;

use App\Enums\OrderStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'residence_id',
        'housing_id',
        'housing_formula_id',
        'date_from',
        'date_to',
        'for_count',
        'status',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
    ];

    public function residence(): BelongsTo
    {
        return $this->belongsTo(Residence::class);
    }

    public function housing(): BelongsTo
    {
        return $this->belongsTo(Housing::class);
    }

    public function formula(): BelongsTo
    {
        return $this->belongsTo(HousingFormula::class, 'housing_formula_id');
    }

    public function priceDetails(): HasMany
    {
        return $this->hasMany(OrderPriceDetail::class, 'order_id');
    }

    public function statusDetails(): HasMany
    {
        return $this->hasMany(OrderStatusDetail::class, 'order_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setToProcessed()
    {
        $this->update([
            'status' => OrderStatuses::Processed->value,
        ]);
    }

    public function setToUnavailable()
    {
        $this->update([
            'status' => OrderStatuses::Unavailable->value,
        ]);
    }
}
