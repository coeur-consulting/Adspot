<?php

namespace App\Http\Resources;

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
            "created_at" => $this->created_at,
            "id" => $this->id,
            "order_no" => $this->order_no,
            "status" => $this->status,
            "tax" => $this->tax,
            "total" => $this->total,
            "updated_at" => $this->updated_at,
            "user" => $this->user,
            "user_id" => $this->user_id
        ];
    }
}
