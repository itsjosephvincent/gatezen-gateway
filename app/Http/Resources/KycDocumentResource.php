<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KycDocumentResource extends JsonResource
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
            'document_type_id' => $this->document_type_id,
            'status' => $this->status,
            'type' => $this->type,
            'file' => $this->file,
            'internal_note' => $this->internal_note,
            'external_note' => $this->external_note,
            'rejeceted_at' => $this->rejeceted_at,
            'approved_at' => $this->approved_at,
            'created_at' => $this->created_at,
            'document_type' => new DocumentTypeResource($this->whenLoaded('document_type')),
        ];
    }
}
