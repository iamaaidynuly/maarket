<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'purpose',
        'size',
        'quantity',
        'created_at',
        'updated_at',
    ];

    public function getType()
    {
        return $this->hasOne(Translate::class, 'id', 'type');
    }

    public function getPurpose()
    {
        return $this->hasOne(Translate::class, 'id', 'purpose');
    }

    public function getSize()
    {
        return $this->hasOne(Translate::class, 'id', 'size');
    }

    public function getQuantity()
    {
        return $this->hasOne(Translate::class, 'id', 'quantity');
    }
}
