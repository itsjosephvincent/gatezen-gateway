<?php

namespace App\Enum;

enum PdfType: string
{
    case CreditNote = 'creditnote';
    case Deal = 'deal';
    case Invoice = 'invoice';
    case Portfolio = 'portfolio';
    case Sale = 'sale';
}
