<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class KycDocument extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'application_id',
        'document_type_id',
        'status',
        'file',
        'internal_note',
        'external_note',
        'rejected_at',
        'approved_at',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('kyc_media')->useDisk('user');
    }

    public function document_type(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function kyc_application(): BelongsTo
    {
        return $this->belongsTo(KycApplication::class);
    }
}
