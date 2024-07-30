<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealEntryResource extends JsonResource
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
            'uuid' => $this->uuid,
            'deal_id' => $this->deal_id,
            'user_id' => $this->user_id,
            'invoice_id' => $this->invoice_id,
            'status' => $this->status,
            'dealable_quantity' => $this->dealable_quantity,
            'billable_price' => $this->billable_price,
            'billable_quantity' => $this->billable_quantity,
            'notes' => $this->notes,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
        ];
    }
}
