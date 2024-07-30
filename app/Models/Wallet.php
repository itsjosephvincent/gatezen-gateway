<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes, UsesUuid;

    protected $fillable = [
        'holdable_type',
        'holdable_id',
        'belongable_type',
        'belongable_id',
        'slug',
        'description',
        'meta',
    ];

    protected static function booted(): void
    {
        static::saving(function ($wallet): void {
            $wallet->slug = $wallet->slug ?? 'euro';
        });
    }

    public function holdable(): MorphTo
    {
        return $this->morphTo();
    }

    public function belongable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getPendingBalanceAttribute()
    {
        return Transaction::where('is_pending', true)
            ->where('wallet_id', $this->id)
            ->sum('amount');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeOfType(Builder $query, string $slug): void
    {
        $query->where('slug', $slug);
    }
}
