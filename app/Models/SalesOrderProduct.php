<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sales_order_id',
        'sellable_type',
        'sellable_id',
        'product_name',
        'description',
        'discount',
        'quantity',
        'price',
        'position',
    ];

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function main(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function sellable(): MorphTo
    {
        return $this->morphTo();
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'payable');
    }
}
