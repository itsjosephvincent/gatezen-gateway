<?php

namespace App\Enum;

enum KycApplicationStatus: string
{
    case Uploaded = 'uploaded';
    case Rejected = 'rejected';
    case Approved = 'approved';
    case Pending = 'pending';
}
