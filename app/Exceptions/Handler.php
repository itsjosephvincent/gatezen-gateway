<?php

namespace App\Exceptions;

use App\Exceptions\Error as ExceptionsError;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $replacement = [
                'id' => collect($e->getIds())->first(),
                'model' => Arr::last(explode('\\', $e->getModel())),
            ];

            $error = new ExceptionsError(
                error: trans('exception.model_not_found.message', $replacement)
            );

            return response($error->toArray(), Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
            //
        });
    }
}
