<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class KycApplication extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'application_status',
        'reference',
        'required_docs',
        'completed_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }

    public function kyc_documents(): HasMany
    {
        return $this->hasMany(KycDocument::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function required_docs(): BelongsToMany
    {
        return $this->belongsToMany(DocumentType::class, 'kyc_required_docs');
    }
}
