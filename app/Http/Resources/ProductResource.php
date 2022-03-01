<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected function handleBids($offers){
        $user = auth()->user();
        return in_array($user->id, $offers->map(function ($a){return $a->user_id;}));

    }
    public function toArray($request)
    {

        return [
            'id'=> $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'media'=> $this->media,
            'impressions' => $this->impressions,
             'dimension' => $this->dimension,
            'duration' => $this->duration,
            'location' => $this->location,
            'type' => $this->type,
            'status' => $this->status,
            'price' => $this->price,
            'featured' => $this->featured,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'category_id' => $this->category_id,
            'subcategory_id'=> $this->subcategory_id,
            'has_bid' => count($this->offers)?$this->handleBids($this->offers):false,
            'bid_count' => count($this->offers),
        ];
    }
}
