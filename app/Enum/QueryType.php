<?php

namespace App\Enum;

enum QueryType: string
{
    case Users = 'users_query';
    case Shares = 'shares_query';
    case Bank = 'bank_transaction_query';
}
