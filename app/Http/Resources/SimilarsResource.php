<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\ProductPriceTypes;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\PersonalAccessToken;

class SimilarsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lang = $request->lang;
        if ($request->bearerToken()) {
            $token = PersonalAccessToken::findToken($request->bearerToken());
            $user = User::find($token->tokenable_id);
            $priceType = $user->price_type_id;
        }
        $product = Product::find($this->id);
        $priceTypes = $product->priceTypes->pluck('price_type_id')->toArray();
        return [
            'id'    =>  $this->id,
            'price' =>  $this->price,
            'title' =>  Product::find($this->id)->getTitle->$lang,
            'category_id'   =>  $this->category_id,
            'main_image'    =>  $this->main_image,
            'slug'  =>  $this->slug,
            'current_price' => isset($priceType) ? (in_array($priceType, $priceTypes) ? ProductPriceTypes::where('price_type_id', $priceType)->where('product_id', $this->id)->value('price') : $this->current_price ) : $this->current_price,
        ];
    }
}
