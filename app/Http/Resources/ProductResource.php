<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\BrandItems;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductFilterRelations;
use App\Models\ProductImages;
use App\Models\ProductPriceTypes;
use App\Models\ShopProduct;
use App\Models\Size;
use App\Models\Translate;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\PersonalAccessToken;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lang = $request->lang;
        $images = ProductImages::where('product_id', $this->id)->pluck('image')->toArray();
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
            'brand' => Brand::join('translates as title', 'title.id', 'brands.title')->join('translates as content', 'content.id', 'brands.content')
                ->where('brands.id', $this->brand_id)
                ->select('brands.id', 'brands.image', 'brands.table_size', 'brands.slug', 'brands.popular', 'title.' . $lang . ' as title', 'content.' . $lang . ' as content', 'brands.created_at',)
                ->first(),
            'brand_items' => isset($this->brand_items_id) ? Translate::where('id', BrandItems::find($this->brand_items_id)->title)->value($lang) : null,
            'country_id' => $this->country_id,
//            'size_id' => Size::join('translates as title', 'title.id', 'sizes.title')->select('sizes.id', 'title.' . $lang . ' as title')->first(),
            'slug' => $this->slug,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'best' => $this->best,
            'new' => $this->new,
            'funds_1' => $this->funds_1,
            'funds_2' => $this->funds_2,
            'main_image' => $this->main_image ?? count($images) > 0 ? ProductImages::where('product_id', $this->id)->value('image') : null,
//            'main_image' => ProductImages::where('product_id', $this->id)->first()->image,
            'menu_position' => $this->menu_position,
            'images' => $images,
            'features' => new ProductFeatureResource(ProductFeature::where('product_id', $this->id)->first()),
            'filters' => ProductFilterRelationsResource::collection(ProductFilterRelations::where('product_id', $this->id)->get()),
            'similars' => SimilarsResource::collection(Product::where('products.id', '!=',$this->id)
                ->where('category_id', $this->category_id)->orderBy('created_at', 'desc')->limit(10)
                ->get()),
            'others'    => ShopProductResource::collection(ShopProduct::whereProductId($this->id)->get()),
        ];
    }
}
