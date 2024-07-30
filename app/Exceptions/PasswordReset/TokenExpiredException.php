<?php

namespace App\Exceptions\PasswordReset;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class TokenExpiredException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function error(): string
    {
        return trans('exception.reset_password_token_expired.message');
    }
}
