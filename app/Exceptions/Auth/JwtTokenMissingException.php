<?php

namespace App\Exceptions\Auth;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class JwtTokenMissingException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    public function error(): string
    {
        return trans('exception.token_not_found.message');
    }
}
