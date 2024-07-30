<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\InvalidSecretKeyException;
use App\Exceptions\Auth\JwtTokenMissingException;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateGatewayAccess
{
    private $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle(Request $request, Closure $next): Response
    {

        if ($request->header('Authorization')) {
            $allSecretKeys = explode(',', env('ALL_SECRET_KEYS'));
            $bearer = $this->jwtService->decryptJwt($request->header('Authorization'), config('services.gateway.secret'));

            if (in_array($bearer->secretkey, $allSecretKeys)) {
                return $next($request);
            }

            throw new InvalidSecretKeyException();
        }

        throw new JwtTokenMissingException();
    }
}
