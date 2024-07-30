<?php

namespace App\Enum;

enum Status: string
{
    case Accepted = 'accepted';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    case Draft = 'draft';
    case Invoiced = 'invoiced';
    case Ongoing = 'ongoing';
    case Paused = 'paused';
    case Pending = 'pending';
    case Rejected = 'rejected';
    case Sent = 'sent';
    case Paid = 'paid';
}
