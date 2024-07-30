<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Ticker extends Model
{
    use HasFactory, HasTags, SoftDeletes, UsesUuid;

    protected $fillable = [
        'project_id',
        'product_id',
        'ticker',
        'slug',
        'name',
        'description',
        'website_url',
        'type',
        'currency_id',
        'market',
        'market_cap',
        'primary_exchange',
        'language_id',
        'is_active',
        'price',
        'price_last_traded',
        'authorized_shares',
        'outstanding_shares',
        'list_date',
    ];

    /**
     * Get the project that owns the Ticker
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the currency that owns the Ticker
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the product that owns the Ticker
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
