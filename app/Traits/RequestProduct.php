<?php
namespace App\Traits;

use App\Models\City;
use App\Models\Shop;
use App\Models\Translate;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait RequestProduct
{
    public function getTitle(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function getDescription(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }
}
