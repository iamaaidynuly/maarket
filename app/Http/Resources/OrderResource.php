<?php

namespace App\Http\Resources;

use App\Models\OrderProducts;
use App\Models\StatusType;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'name'  =>  $this->name,
            'surname'   =>  $this->lname,
            'phone' =>  $this->phone,
            'email' =>  $this->email,
            'comment'   =>  $this->comment,
            'delivery'  =>  $this->delivery,
            'payment_method'    =>  $this->pay_method,
            'date'  =>  $this->date,
            'status'    =>  Translate::where('id', StatusType::where('id', $this->status)->value('name'))->value($request->lang),
            'pay_status'    =>  $this->pay_status,
            'total_price'   =>  $this->total_price,
            'products'  => OrderProductResource::collection(OrderProducts::where('order_id', $this->id)->get()),
        ];
    }
}
