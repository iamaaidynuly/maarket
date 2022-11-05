<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Region;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'region_id' =>  $this->region_id,
            'city_id' =>  $this->city_id,
            'region_name'   => Translate::where('id', Region::where('id', $this->region_id)->value('title'))->value($lang),
            'city_name'   => Translate::where('id', City::where('id',$this->city_id)->value('title'))->value($lang),
            'address'       =>  $this->address,
            'apartment' =>  $this->apartment,
        ];
    }
}
