<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PdfTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'project_id',
        'name',
        'is_default',
        'html_template',
        'pdf_settings',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'pdf_settings' => 'json',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
