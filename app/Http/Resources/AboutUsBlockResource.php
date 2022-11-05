<?php

namespace App\Http\Resources;

use App\Http\Controllers\Backend\BrandsController;
use App\Models\AboutUsBlockImage;
use App\Models\Brand;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsBlockResource extends JsonResource
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

        return [
            'id'    =>  $this->id,
            'created_at'    =>  $this->created_at,
            'image' =>  $this->image,
            'image_mobile'  =>  $this->image_mobile,
            'title' =>  Translate::where('id', $this->title)->value($lang),
            'description' =>  Translate::where('id', $this->description)->value($lang),
            'slug'  =>  $this->slug,
            'url'   =>  $this->url,
            'additional_images' =>  AboutUsBlockImage::where('about_us_block_id', $this->id)->exists() ? AboutUsBlockImage::where('about_us_block_id', $this->id)->pluck('image')->toArray() : false,
            'brands'    => $this->slug == 'payment' ? BrandResource::collection(Brand::get()) : null,
        ];
    }
}
