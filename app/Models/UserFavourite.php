<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'created_at',
        'updated_at',
    ];

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
