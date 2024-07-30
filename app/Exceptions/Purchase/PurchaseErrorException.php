<?php

namespace App\Exceptions\Purchase;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class PurchaseErrorException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function error(): string
    {
        return trans('exception.purchase_error_exception.message');
    }
}
