<?php

namespace App\Exceptions\Auth;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class InvalidSecretKeyException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    public function error(): string
    {
        return trans('exception.invalid_token.message');
    }
}
