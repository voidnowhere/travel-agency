<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_by',
        'is_active',
    ];
}
