<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalDataType extends Model
{
    use HasFactory;

    protected $table = 'external_data_types';

    protected $guarded = ['id'];
}
