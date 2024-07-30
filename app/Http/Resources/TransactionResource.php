<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'payable_type' => $this->payable_type,
            'payable_id' => $this->payable_id,
            'wallet_id' => $this->wallet_id,
            'amount' => $this->amount,
            'is_pending' => $this->is_pending,
            'description' => $this->description,
            'meta' => $this->meta,
            'transaction_type' => $this->transaction_type,
            'created_at' => $this->created_at,
        ];
    }
}
