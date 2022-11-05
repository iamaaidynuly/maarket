<?php

namespace App\Http\Resources;

use App\Models\Filter;
use App\Models\FilterItems;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFilterRelationsResource extends JsonResource
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
            'filter_item_id'    =>  $this->filter_item_id,
            'filter_item_title' =>  FilterItems::find($this->filter_item_id)->getTitle->$lang,
            'filter_id'     =>  FilterItems::find($this->filter_item_id)->filter_id,
            'filter_title'  =>  FilterItems::find($this->filter_item_id)->getParent->getTitle->$lang
        ];
    }
}
