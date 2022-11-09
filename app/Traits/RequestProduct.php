<?php

namespace App\Traits;

use App\Models\Brand;
use App\Models\BrandItems;
use App\Models\City;
use App\Models\Country;
use App\Models\Shop;
use App\Models\ShopRequestProductFilterRelation;
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

    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function brand_items(): HasOne
    {
        return $this->hasOne(BrandItems::class, 'id', 'brand_items_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function filters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopRequestProductFilterRelation::class, 'shop_request_product_id', 'id');
    }
}
