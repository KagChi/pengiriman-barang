<?php
    use Firebase\JWT\JWT;

    function createCSRFJWT() {
        $currentTime = time();
        $expirationTime = $currentTime + 300; // 5 Minutes
        $key = $_ENV["JWT_SECRET"];
        $payload = [
            'iss' => 'anterkuy',
            'aud' => 'csrf',
            'iat' => $currentTime,
            'exp' => $expirationTime
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }
?>