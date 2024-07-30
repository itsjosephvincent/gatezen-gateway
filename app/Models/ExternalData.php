<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalData extends Model
{
    use HasFactory;

    protected $table = 'external_datas';

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'external_id',
        'data',
        'external_data_type_id',
        'externable_type',
        'externable_id',
    ];

    /**
     * Get the owning externable model.
     */
    public function externable()
    {
        return $this->morphTo();
    }

    public function externalDataType()
    {
        return $this->belongsTo(ExternalDataType::class);
    }
}
