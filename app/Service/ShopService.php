<?php

namespace App\Service;

use App\Models\Shop;
use App\Models\Translate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ShopService extends TranslateService
{
    public function create($data)
    {
        $title = TranslateService::translateCreate($data['title']);
        $description = TranslateService::translateCreate($data['description']);
        $address = TranslateService::translateCreate($data['address']);
        $minPrice = TranslateService::translateCreate($data['min_price']);
        $delivery = TranslateService::translateCreate($data['delivery']);

        if (isset($data['icon'])) {
            $file = $data['icon'];
            $name = hexdec(uniqid()) . '.' . $file->extension();
            $path = 'shop';
            $icon = $file->storeAs($path, $name, 'static');
        }

        $shop = Shop::create([
            'name' => $title->id,
            'description' => $description->id,
            'address' => $address->id,
            'min_price' => $minPrice->id,
            'delivery' => $delivery->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'city_id' => $data['city_id'],
            'icon' => $icon ?? null,
        ]);

        return $shop;
    }

    public function update(Shop $shop, $data): Shop
    {
        $name = TranslateService::translateUpdate($shop->name, $data['title']);
        $description = TranslateService::translateUpdate($shop->description, $data['description']);
        $address = TranslateService::translateUpdate($shop->address, $data['address']);
        $minPrice = TranslateService::translateUpdate($shop->min_price, $data['min_price']);
        $delivery = TranslateService::translateUpdate($shop->delivery, $data['delivery']);
        $shop->update([
            'email' => isset($data['email']) ? $data['email'] : null,
            'city_id' => isset($data['city_id']) ? $data['city_id'] : null,
            'verified_at' => isset($data['verified']) ? Carbon::now() : null,
        ]);

        return $shop;
    }
}
