<?php

namespace App\Exceptions\Auth;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class EmailExistsException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function error(): string
    {
        return trans('exception.email_already_exist.message');
    }
}
