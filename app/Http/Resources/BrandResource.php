<?php

namespace App\Http\Resources;

use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'title' =>  Translate::where('id',$this->title)->value($lang),
            'content' =>  Translate::where('id',$this->content)->value($lang),
            'image' =>  $this->image,
            'table_size'    =>  $this->table_size,
            'slug'  =>  $this->slug,
        ];
    }
}
