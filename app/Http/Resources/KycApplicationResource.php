<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KycApplicationResource extends JsonResource
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
            'user_id' => $this->user_id,
            'application_status' => $this->application_status,
            'reference' => $this->reference,
            'internal_note' => $this->internal_note,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
            'kyc_documents' => KycDocumentResource::collection($this->whenLoaded('kyc_documents')),
            'required_docs' => DocumentTypeResource::collection($this->whenLoaded('required_docs')),
        ];
    }
}
