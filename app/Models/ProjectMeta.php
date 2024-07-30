<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMeta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'field',
        'value',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function prefixSeriesCheck($project_id)
    {
        $meta = self::where('project_id', $project_id)
            ->whereIn('field', ['sales-order-prefix', 'sales-order-series', 'invoice-series', 'invoice-prefix'])
            ->get()
            ->pluck('value', 'field');

        if ($meta->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }
}
