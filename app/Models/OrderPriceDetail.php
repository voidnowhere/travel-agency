<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPriceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'type_SHML',
        'price',
    ];
}
