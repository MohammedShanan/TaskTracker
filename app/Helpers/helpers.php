<?php

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

function decodeToken($token)
{
    $secretKey = env('JWT_SECRET');
    $algorithm = 'HS256';
    try {
        $decoded = JWT::decode($token, new key($secretKey, $algorithm));
        return $decoded->user_id;
    } catch (Exception) {
        return null;
    }
}
