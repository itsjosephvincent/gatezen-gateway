<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sync extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'data',
        'results',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function main(): BelongsTo
    {
        return $this->belongsTo(Sync::class, 'id');
    }
}
