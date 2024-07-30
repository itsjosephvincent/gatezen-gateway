<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = [
        'currency_type_id',
        'name',
        'code',
        'symbol',
    ];

    /**
     * Get the currencyType that owns the Currency
     */
    public function currencyType(): BelongsTo
    {
        return $this->belongsTo(CurrencyType::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function sales_order_products(): HasMany
    {
        return $this->hasMany(SalesOrderProduct::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
