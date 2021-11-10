<?php

use App\Models\ModelOtentikasi;
use Firebase\JWT\JWT;

    function getJWT($otentikasiHeader){
        if (is_null($otentikasiHeader)) {
            # code...
            throw new Exception("Otentikasi JWT Gagal");
        }
        return explode(" ",$otentikasiHeader)[1];
    }

    function validateJWT($encodedToken){
        $key = getenv('JWT_SECRET_KEY');
        $decodeToken = JWT::decode($encodedToken, $key, ['HS256']);
        $modelOtentikasi = new ModelOtentikasi();
        $modelOtentikasi->getEmail($decodeToken->email);
    }

    function createJWT($email){
        $waktuRequest = time();
        $waktuToken = getenv('JWT_TIME_TO_LIVE');
        $expiredTime = $waktuRequest + $waktuToken;
        $payload = [
            'email' => $email,
            'iat'   => $waktuRequest,
            'exp'   => $expiredTime
        ];

        $jwt = JWT::encode($payload,getenv('JWT_SECRET_KEY'));
        return $jwt;
    }