<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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
            'currency_type_id' => $this->currency_type_id,
            'name' => $this->name,
            'code' => $this->code,
            'symbol' => $this->symbol,
            'created_at' => $this->created_at,
        ];
    }
}
