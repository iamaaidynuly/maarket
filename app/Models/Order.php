<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
        'name',
        'phone',
        'email',
        'comment',
        'product_id',
        'count',
        'status',
        'l_name',
        'created_at',
        'delivery',
        'pay_method',
        'date',
        'product_id',
        'user_id',
        'count',
        'status',
        'pay_status',
        'total_price',
        'promocode'
    ];

    public function getProducts()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

    public function getStatus()
    {
        return $this->hasOne(PayStatus::class, 'order_id', 'id');
    }

    public function getType()
    {
        return $this->hasOne(StatusType::class, 'id', 'status');
    }
}
