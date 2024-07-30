<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class KycRequiredDoc extends Pivot
{
    use HasFactory;

    protected $table = 'kyc_required_docs';
}
