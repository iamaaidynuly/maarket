<?php
namespace App\Service;

use App\Models\Shop;
use App\Models\Translate;
use Illuminate\Support\Facades\Hash;
use function Sodium\add;

class CreateShop extends TranslateService
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
            'name' =>  $title->id,
            'description' =>  $description->id,
            'address' =>  $address->id,
            'min_price' =>  $minPrice->id,
            'delivery' =>  $delivery->id,
            'email' =>  $data['email'],
            'password'  =>  Hash::make($data['password']),
            'city_id'   =>  $data['city_id'],
            'icon'      =>  $icon ?? null,
        ]);

        return $shop;
    }
}
