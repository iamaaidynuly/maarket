<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'city_id'   =>  $this->city_id,
            'city_name' =>  City::where('id', $this->city_id)->first()->getTitle->$lang,
            'adds'  =>  Translate::where('id', $this->adds)->value($request->lang),
        ];
    }
}
