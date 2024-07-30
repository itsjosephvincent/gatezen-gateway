<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SegmentUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'segment_id',
        'user_id',
    ];

    protected $primaryKey = 'segment_id';

    public $incrementing = false;

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
