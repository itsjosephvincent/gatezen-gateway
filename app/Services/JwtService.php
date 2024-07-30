<?php

namespace App\Services;

use SimpleJWT\JWE;
use SimpleJWT\Keys\KeySet;

class JwtService
{
    public function decryptJwt($jwtKey, $key)
    {
        $token = explode(' ', $jwtKey)[1];
        $set = \SimpleJWT\Keys\KeySet::createFromSecret($key);
        $jwt = JWE::decrypt($token, $set, 'PBES2-HS256+A128KW');

        return json_decode($jwt->getPlaintext());
    }

    public function encrypyJwt($email, $key)
    {
        $set = \SimpleJWT\Keys\KeySet::createFromSecret($key);
        $headers = ['alg' => 'PBES2-HS256+A128KW', 'enc' => 'A128CBC-HS256'];
        $claims = json_encode(['secretkey' => $key, 'email' => $email]);
        $jwt = new \SimpleJWT\JWE($headers, $claims);
        $result = $jwt->encrypt($set);

        return $result;
    }

    public function createKey($key)
    {
        return KeySet::createFromSecret($key);
    }
}
