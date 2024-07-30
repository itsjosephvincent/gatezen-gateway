<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'dealable_type',
        'dealable_id',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    public function dealable(): MorphTo
    {
        return $this->morphTo();
    }

    public function deal_entries(): HasMany
    {
        return $this->hasMany(DealEntry::class);
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'payable');
    }
}
