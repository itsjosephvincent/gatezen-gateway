<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'public_name' => $this->public_name,
            'public_url' => $this->public_url,
            'website_url' => $this->website_url,
            'logo_url' => isset($this->logo_url) ? asset('storage/projects/logo/'.$this->logo_url) : null,
            'featured_image' => isset($this->featured_image) ? asset('storage/projects/featured/'.$this->featured_image) : null,
            'summary' => $this->summary,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'established_at' => $this->established_at,
            'created_at' => $this->created_at,
            'tickers' => TickerResource::collection($this->whenLoaded('tickers')),
        ];
    }
}
