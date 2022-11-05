<?php

namespace App\Http\Resources;

use App\Models\Translate;
use App\Models\User;
use App\Models\UserFavourite;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\PersonalAccessToken;

class SaleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->bearerToken()) {
            $token = PersonalAccessToken::findToken($request->bearerToken());
            if ($token) {
                $user = User::find($token->tokenable_id);
                $fav = UserFavourite::where('user_id', $user->id)->where('product_id', $this->id)->exists();
            }
        }

        return [
            'id' => $this->id,
            'title' => Translate::where('id', $this->title)->value($request->lang),
            'main_image' => $this->main_image,
            'current_price' => $this->current_price,
            'price' => $this->price,
            'favourite' => $fav ?? false,
            'slug' => $this->slug,
            'user_favourite_id' =>  isset($user) ? UserFavourite::where('user_id', $user->id)->where('product_id', $this->id)->value('id') : false,
        ];
    }
}
