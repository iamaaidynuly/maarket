<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopProduct
 *
 * @property int $id
 * @property int $shop_id
 * @property int $product_id
 * @property int $price
 * @property int $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopProduct extends Model
{
    use HasFactory;

    protected $table = 'shop_products';

    const STATUS_AVAILABLE = true;
    const STATUS_NOT_AVAILABLE = false;

    protected $fillable = [
        'shop_id',
        'product_id',
        'available',
        'created_at',
        'updated_at',
        'price',
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
