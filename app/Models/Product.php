<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'currency_id',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function sales_orders_products(): HasMany
    {
        return $this->hasMany(SalesOrderProduct::class);
    }

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function tickers(): HasMany
    {
        return $this->hasMany(Ticker::class);
    }
}
