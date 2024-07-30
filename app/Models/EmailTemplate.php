<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email_type_id',
        'project_id',
        'name',
        'from_name',
        'from_email',
        'cc_emails',
        'bcc_emails',
        'is_default',
        'subject',
        'body_text',
        'body_html',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'cc_emails' => 'json',
        'bcc_emails' => 'json',
    ];

    public function email_type(): BelongsTo
    {
        return $this->belongsTo(EmailType::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
