<?php

namespace App\Models;

use App\Jobs\SegmentJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(function ($user): void {
            SegmentJob::dispatch();
        });
    }

    public function segment_conditions(): HasMany
    {
        return $this->hasMany(SegmentCondition::class);
    }

    public function segment_users(): HasMany
    {
        return $this->hasMany(SegmentUser::class);
    }
}
