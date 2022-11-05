<?php

namespace App\Http\Resources;

use App\Models\Review;
use App\Models\UserAddress;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lname' => $this->lname,
            'sname' => $this->sname,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'bday' => $this->bday,
            'role' => (int)$this->role,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'code' => $this->code,
            'code_activate' => $this->code_activate,
            'code_date' => $this->code_date,
            'addresses' => UserAddressResource::collection(UserAddress::where('user_id', $this->id)->get()),
            'type' => $this->type,
            'bin' => $this->bin,
            'discount' => (integer)$this->discount,
            'actual_address' => $this->actual_address,
            'entity_address' => $this->entity_address,
            'reviews' => Review::where('user_id', $this->id)->join('products', 'products.id', 'reviews.product_id')
                ->join('translates as product_title', 'product_title.id', 'products.title')
                ->where('reviews.status', '!=', 'declined')
                ->select('reviews.id', 'reviews.name', 'reviews.review as comment', 'reviews.rating', 'product_title.' . $request->lang . ' as product_title', 'reviews.status', 'reviews.product_id', 'reviews.created_at')
                ->orderBy('reviews.created_at', 'desc')
                ->get(),
        ];
    }
}
