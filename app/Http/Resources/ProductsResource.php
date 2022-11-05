<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\BrandItems;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductFilterRelations;
use App\Models\ProductImages;
use App\Models\ProductPriceTypes;
use App\Models\Translate;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\PersonalAccessToken;

class ProductsResource extends JsonResource
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
            'id' => $this->id,
            'title' => Translate::where('id', $this->title)->value($lang),
            'description' => Translate::where('id', $this->description)->value($lang),
            'short_description' => Translate::where('id', $this->short_description)->value($lang),
            'specifications' => Translate::where('id', $this->specifications)->value($lang),
            'artikul' => $this->artikul,
            'price' => $this->price,
            'sale' => $this->sale,
            'current_price' => isset($priceType) ? (in_array($priceType, $priceTypes) ? ProductPriceTypes::where('price_type_id', $priceType)->where('product_id', $this->id)->value('price') : $this->current_price ) : $this->current_price,
            'slug' => $this->slug,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'main_image' => $this->main_image,
            'menu_position' => $this->menu_position,
            'funds_1' =>  $this->funds_1,
            'funds_2' =>  $this->funds_2,
        ];
    }
}
