<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavouriteResource extends JsonResource
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
            'user_id'   =>  $this->user_id,
            'created_at'    =>  $this->created_at,
            'product_id'   =>  $this->product_id,
            'main_image' =>  Product::where('id', $this->product_id)->value('main_image'),
            'price' =>  Product::where('id', $this->product_id)->value('price'),
            'current_price' =>  Product::where('id', $this->product_id)->value('current_price'),
            'title' =>  Translate::where('id', Product::where('id', $this->product_id)->value('title'))->value($request->lang),
        ];
    }
}
