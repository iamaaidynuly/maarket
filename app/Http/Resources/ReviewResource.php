<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'created_at'    =>  $this->created_at,
            'name'  =>  $this->name,
            'review'    =>  $this->review,
            'rating'    =>  $this->rating,
            'user'  =>  User::where('id',$this->user_id)->select('users.id','users.name', 'users.lname', 'users.sname', 'users.phone_number')->first(),
            'product_id'    =>  $this->product_id,
        ];
    }
}
