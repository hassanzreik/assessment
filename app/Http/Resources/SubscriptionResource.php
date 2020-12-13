<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        		"id" => $this->id,
		        "mobile_number" => $this->mobile_number,
		        "expiry_date" => strtotime($this->expiry_date),
		        "status" => $this->status,
		        "product" => ProductResource::make($this->product),
		        "operator" => OperatorResource::make($this->operator),

        ];
    }
}
