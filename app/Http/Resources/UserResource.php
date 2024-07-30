<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'mobile' => $this->mobile,
            'mobile_verified_at' => $this->mobile_verified_at,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'is_blocked' => $this->is_blocked,
            'language_id' => $this->language_id,
            'language' => new LanguageResource($this->whenLoaded('language')),
            'address' => new AddressResource($this->whenLoaded('address')),
        ];
    }
}
