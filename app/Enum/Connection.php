<?php

namespace App\Enum;

enum Connection: string
{
    case MYSQL = 'mysql';
    case SQL = 'sqlsrv';
}
