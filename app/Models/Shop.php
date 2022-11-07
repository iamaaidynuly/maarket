<?php

namespace App\Models;

use App\Traits\TranslateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory, TranslateTrait;

    protected $fillable = [
        'email',
        'password',
        'name',
        'description',
        'address',
        'rating',
        'city_id',
        'icon',
        'min_price',
        'delivery',
        'created_at',
        'updated_at',
        'verified_at',
    ];
}
