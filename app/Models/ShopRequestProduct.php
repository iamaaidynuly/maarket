<?php

namespace App\Models;

use App\Traits\RequestProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRequestProduct extends Model
{
    use HasFactory, RequestProduct;

    protected $table = 'shop_request_products';

    const STATUS_IN_PROCESS = 'in_process';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DECLINED = 'declined';

    protected $fillable = [
        'shop_id',
        'title',
        'description',
        'price',
        'sale',
        'current_price',
        'brand_id',
        'brand_items_id',
        'country_id',
        'slug',
        'best',
        'new',
        'status',
        'created_at',
        'updated_at',
        'artikul',
    ];
}
