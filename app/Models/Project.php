<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Project extends Model implements HasMedia
{
    use HasFactory, HasTags, InteractsWithMedia, SoftDeletes, UsesUuid;

    protected $fillable = [
        'name',
        'public_name',
        'public_url',
        'website_url',
        'logo_url',
        'featured_image',
        'summary',
        'description',
        'is_active',
        'established_at',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_media')->useDisk('project');
    }

    /**
     * Get the tickers that owns the Project
     */
    public function tickers(): HasMany
    {
        return $this->hasMany(Ticker::class);
    }

    public function wallets(): MorphMany
    {
        return $this->morphMany(Wallet::class, 'belongable');
    }

    public function sales_orders(): HasMany
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function project_metas(): HasMany
    {
        return $this->hasMany(ProjectMeta::class);
    }

    public function email_templates(): HasMany
    {
        return $this->hasMany(EmailTemplate::class);
    }

    public function pdf_templates(): HasMany
    {
        return $this->hasMany(PdfTemplate::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
