<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'currency_id' => $this->currency_id,
            'language_id' => $this->language_id,
            'template_id' => $this->template_id,
            'status' => $this->status,
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'sent_at' => $this->sent_at,
            'note' => $this->note,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'invoice_products' => InvoiceProductResource::collection($this->whenLoaded('invoice_products')),
        ];
    }
}
