<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRequestProductFilterRelation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected function filter_item(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(FilterItems::class, 'id', 'filter_item_id');
    }
}
