<?php

namespace App\Http\Resources;

use App\Models\Shop;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    =>  $this->id,
            'shop_id'   =>  $this->shop_id,
            'shop_name' =>  Shop::find($this->shop_id)->getName->ru,
            'product_id'    =>  $this->product_id,
            'status'    =>  boolval($this->status),
            'price' =>  $this->price,
        ];
    }
}
