<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Translate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait TranslateTrait
{
    public function getName(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'name');
    }

    public function getDescription(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function getAddress(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'address');
    }

    public function getMinPrice(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'min_price');
    }

    public function getDelivery(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'delivery');
    }

    public function getCity(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
