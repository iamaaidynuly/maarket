<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRequestImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'shop_request_product_id',
        'image',
    ];
}
