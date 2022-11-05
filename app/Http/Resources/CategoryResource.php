<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'title' =>  Translate::where('id', $this->title)->value($lang),
            'slug'  =>  $this->slug,
            'created_at'    =>  $this->created_at,
            'sub_categories'    =>  SubCategoryResource::collection(Category::where('parent_id', $this->id)->get()),
        ];
    }
}
