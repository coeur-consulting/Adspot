<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'name' => $this->name,
            'description' => $this->description,
            'media' => $this->media,
            'available' => $this->available,
            'location' => $this->location,
            'type' => $this->type,
            'status' => $this->status,
            'price' => $this->price,
            'start' => $this->start,
            'end' => $this->end,
            'other' => $this->other,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'has_bid' => $this->handleBids($this->offers),
            'bid_count' => count($this->offers),
            'bids' => $this->offers
        ];
    }
}
