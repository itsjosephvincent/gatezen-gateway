<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'addressable_type' => $this->addressable_type,
            'addressable_id' => $this->addressable_id,
            'co' => $this->co,
            'street' => $this->street,
            'street2' => $this->street2,
            'city' => $this->city,
            'postal' => $this->postal,
            'county' => $this->county,
            'countries_id' => $this->countries_id,
            'verified_at' => $this->verified_at,
            'created_at' => $this->created_at,
            'countries' => new CountryResource($this->whenLoaded('countries')),
        ];
    }
}
