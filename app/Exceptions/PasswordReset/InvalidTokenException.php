<?php

namespace App\Exceptions\PasswordReset;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class InvalidTokenException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function error(): string
    {
        return trans('exception.invalid_reset_password_token.message');
    }
}
