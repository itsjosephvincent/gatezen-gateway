<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
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
            'project_id' => $this->project_id,
            'customer_id' => $this->customer_id,
            'invoice_id' => $this->invoice_id,
            'language_id' => $this->language_id,
            'currency_id' => $this->currency_id,
            'template_id' => $this->template_id,
            'status' => $this->status,
            'order_number' => $this->order_number,
            'order_date' => $this->order_date,
            'note' => $this->note,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'sales_order_products' => SalesOrderProductsResource::collection($this->whenLoaded('sales_order_products')),
        ];
    }
}
