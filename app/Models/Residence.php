<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Residence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city_id',
        'residence_category_id',
        'description',
        'website',
        'email',
        'contact',
        'tax',
        'order_by',
        'is_active',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ResidenceCategory::class, 'residence_category_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
