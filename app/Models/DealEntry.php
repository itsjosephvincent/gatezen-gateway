<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealEntry extends Model
{
    use HasFactory, SoftDeletes, UsesUuid;

    protected $fillable = [
        'deal_id',
        'user_id',
        'invoice_id',
        'status',
        'dealable_quantity',
        'billable_price',
        'billable_quantity',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function main(): BelongsTo
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'payable');
    }
}
