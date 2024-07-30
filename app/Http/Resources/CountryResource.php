<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'name' => $this->name,
            'phone_code' => $this->phone_code,
            'iso_2' => $this->iso_2,
            'iso_3' => $this->iso_3,
            'currency_id' => $this->currency_id,
            'created_at' => $this->created_at,
        ];
    }
}
