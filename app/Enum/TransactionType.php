<?php

namespace App\Enum;

enum TransactionType: string
{
    case Bought = 'Bought';
    case Sold = 'Sold';
    case Transferred = 'Transferred';
}
