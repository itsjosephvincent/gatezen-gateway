<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SegmentCondition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'segment_id',
        'model_type',
        'field',
        'operator',
        'value',
    ];

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }
}
