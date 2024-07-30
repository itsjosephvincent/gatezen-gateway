<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sales_order_id' => $this->sales_order_id,
            'sellable_type' => $this->sellable_type,
            'sellable_id' => $this->sellable_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'discount' => $this->discount,
            'position' => $this->position,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
        ];
    }
}
