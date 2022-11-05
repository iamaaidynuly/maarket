<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceTypes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'price_type_id',
        'price',
    ];

    public function name()
    {
        return $this->hasOne(PriceType::class, 'id', 'price_type_id');
    }
}
