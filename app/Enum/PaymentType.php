<?php

namespace App\Enum;

enum PaymentType: string
{
    case Cash = 'cash';
    case Bank = 'bank_transfer';
}
