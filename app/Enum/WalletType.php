<?php

namespace App\Enum;

enum WalletType: string
{
    case Shares = 'share';
    case Tokens = 'token';
}
