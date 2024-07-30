<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'holdable_type' => $this->holdable_type,
            'holdable_id' => $this->holdable_id,
            'belongable_type' => $this->belongable_type,
            'belongable_id' => $this->belongable_id,
            'slug' => $this->slug,
            'description' => $this->description,
            'meta' => $this->meta,
            'balance' => $this->balance,
            'pending_balance' => $this->pending_balance,
            'created_at' => $this->created_at,
            'holdable' => new UserResource($this->whenLoaded('holdable')),
            'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
            'belongable' => new TickerResource($this->whenLoaded('belongable')),
        ];
    }
}
