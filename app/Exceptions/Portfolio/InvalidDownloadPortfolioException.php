<?php

namespace App\Exceptions\Portfolio;

use App\Exceptions\ApplicationException;
use Illuminate\Http\Response;

class InvalidDownloadPortfolioException extends ApplicationException
{
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function error(): string
    {
        return trans('exception.no_portfolio_info.message');
    }
}
