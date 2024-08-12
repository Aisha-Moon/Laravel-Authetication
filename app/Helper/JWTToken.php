<?php

namespace App\Helper;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Request;


class JWTToken{


    public static function CreateToken(string $userEmail): string
    {
        $key = env('JWT_KEY');

        // Ensure the key is a string
        if (!is_string($key)) {
            throw new \InvalidArgumentException("JWT key must be a string. Current type: " . gettype($key));
        }

        $payload = [
            'iss' => 'laravel-token',  // Issuer
            'iat' => time(),           // Issued at
            'exp' => time() + 3600,    // Expiration time (1 hour)
            'userEmail' => $userEmail, // Custom data
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken(string $token): string
    {
        try {
            $key = env('JWT_KEY');

            // Ensure the key is a string
            if (!is_string($key)) {
                throw new \InvalidArgumentException("JWT key must be a string. Current type: " . gettype($key));
            }

            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Access the userEmail from the decoded token
            return $decoded->userEmail;
        } catch (\Exception $e) {
            return "unauthorized";
        }
    }


}
