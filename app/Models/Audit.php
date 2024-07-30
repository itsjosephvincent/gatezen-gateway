<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Models\Audit as AuditModel;

class Audit extends AuditModel
{
    use HasFactory;
}
