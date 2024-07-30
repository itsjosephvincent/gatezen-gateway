<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceProductResource extends JsonResource
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
            'invoice_id' => $this->invoice_id,
            'invoiceable_type' => $this->invoiceable_type,
            'invoiceable_id' => $this->invoiceable_id,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'position' => $this->position,
            'discount' => $this->discount,
            'created_at' => $this->created_at,
        ];
    }
}
