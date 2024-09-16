<?php

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Decode a JWT token to extract the user ID.
 *
 * This function takes a JSON Web Token (JWT) and decodes it using the secret key
 * defined in the environment variables. It uses the HS256 algorithm for decoding.
 *
 * @param string $token The JWT token to decode.
 * 
 * @return int|null Returns the user ID if decoding is successful, or null if decoding fails.
 * 
 * @throws \Firebase\JWT\ExpiredException If the token has expired.
 * @throws \Firebase\JWT\SignatureInvalidException If the signature is invalid.
 * @throws \Firebase\JWT\BeforeValidException If the token is used before it is allowed.
 * @throws \UnexpectedValueException If the token is invalid in other ways.
 */
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
