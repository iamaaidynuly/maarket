<?php

namespace App\Http\Resources;

use App\Models\ProductFeature;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lang = $request->lang;

        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'type' => Translate::where('id', $this->type)->value($lang),
            'purpose' => Translate::where('id', $this->purpose)->value($lang),
            'size' => Translate::where('id', $this->size)->value($lang),
            'quantity' => Translate::where('id', $this->quantity)->value($lang),
            'created_at' => $this->created_at,
        ];
    }
}
