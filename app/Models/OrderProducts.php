<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_products';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'count',
        'price',
        'created_at',
        'updated_at',
        'funds_1',
        'funds_2',
        'funds_1_bonus',
        'funds_2_bonus',
    ];

    public function getTitle()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
