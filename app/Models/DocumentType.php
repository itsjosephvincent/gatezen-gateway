<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function kyc_documents(): HasMany
    {
        return $this->hasMany(KycDocument::class);
    }

    public function kyc_applications(): BelongsToMany
    {
        return $this->belongsToMany(KycApplication::class, 'kyc_required_docs');
    }
}
