<?php

namespace App\Http\Resources;

use App\Models\FilterItems;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
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
            'items' => FilterItemsResource::collection(FilterItems::where('filter_id', $this->id)->get())
        ];
    }
}
