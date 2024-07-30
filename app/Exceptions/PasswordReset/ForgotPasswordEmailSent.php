<?php

namespace App\Exceptions\PasswordReset;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class ForgotPasswordEmailSent extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_OK;
    }

    public function error(): string
    {
        return trans('exception.reset_password_email_sent.message');
    }
}
