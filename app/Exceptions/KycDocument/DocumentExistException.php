<?php

namespace App\Exceptions\KycDocument;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class DocumentExistException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function error(): string
    {
        return trans('exception.kyc_document_exist.message');
    }
}
