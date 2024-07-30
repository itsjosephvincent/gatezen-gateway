<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TickerResource extends JsonResource
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
            'project_id' => $this->project_id,
            'product_id' => $this->product_id,
            'ticker' => $this->ticker,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'website_url' => $this->website_url,
            'class' => $this->class,
            'currency_id' => $this->currency_id,
            'market' => $this->market,
            'market_cap' => $this->market_cap,
            'primary_exchange' => $this->primary_exchange,
            'language_id' => $this->language_id,
            'is_active' => $this->is_active,
            'price' => $this->price,
            'price_last_traded' => $this->price_last_traded,
            'authorized_shares' => $this->authorized_shares,
            'outstanding_shares' => $this->outstanding_shares,
            'list_date' => $this->list_date,
            'created_at' => $this->created_at,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
        ];
    }
}
