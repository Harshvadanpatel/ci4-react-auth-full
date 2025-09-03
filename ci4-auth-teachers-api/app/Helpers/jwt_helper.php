<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('jwt_encode')) {
    function jwt_encode(array $payload): string {
        $secret = getenv('JWT_SECRET') ?: 'changeme';
        $now = time();
        $exp = $now + (int) (getenv('JWT_EXPIRES_IN') ?: 3600);
        $payload = array_merge([ 'iat' => $now, 'exp' => $exp ], $payload);
        return JWT::encode($payload, $secret, 'HS256');
    }
}

if (!function_exists('jwt_decode')) {
    function jwt_decode(string $token) {
        $secret = getenv('JWT_SECRET') ?: 'changeme';
        return JWT::decode($token, new Key($secret, 'HS256'));
    }
}
