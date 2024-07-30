<?php

namespace App\Enum;

enum KycDocumentStatus: string
{
    case Pending = 'pending';
    case Waiting = 'waiting_feedback';
    case Rejected = 'rejected';
    case Approved = 'approved';
    case Missing = 'missing';
}
