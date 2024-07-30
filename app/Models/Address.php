<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'co',
        'street',
        'street2',
        'city',
        'postal',
        'county',
        'countries_id',
        'verified_at',
    ];

    public function countries(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
