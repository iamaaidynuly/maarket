<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'product_name'  =>  Translate::where('id', Product::where('id', $this->product_id)->value('title'))->value($request->lang),
            'count' =>  $this->count,
            'product_id'    =>  $this->product_id,
        ];
    }
}
