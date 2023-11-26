<?php

namespace APP\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static  function createToken($userEmail, $userID)
    {

        $key =  env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail, 
            'userID' => $userID 
        ];
        return JWT::encode($payload, $key, 'HS256');
    }
    public static  function createTokenForSetPassword($userEmail)
    {

        $key =  env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 *5,
            'userEmail' => $userEmail
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function verifyToken($token)
    {
        try {

            if($token == null){
                return 'unauthorize';
            }else{
                $key =  env('JWT_KEY');
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            }
        } catch (Exception $e) {
            return 'unauthorize';
        }
    }
}
