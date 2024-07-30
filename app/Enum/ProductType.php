<?php

namespace App\Enum;

enum ProductType: string
{
    case Physical = 'physical';
    case Service = 'service';
    case Ticker = 'ticker';
}
