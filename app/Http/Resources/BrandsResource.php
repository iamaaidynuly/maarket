<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\BrandItems;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandsResource extends JsonResource
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

        return [
            'id' => $this->id,
            'title' => Brand::find($this->id)->getTitle->$lang,
            'content' => Brand::find($this->id)->getContent->$lang,
            'image' => $this->image,
            'table_size' => $this->table_size,
            'slug' => $this->slug,
            'popular' => $this->popular,
            'items' => BrandItems::join('translates as title', 'title.id', 'brand_items.title')->where('brand_items.brand_id', $this->id)
                ->select('brand_items.id', 'title.' . $lang . ' as title')->get(),
        ];
    }
}
