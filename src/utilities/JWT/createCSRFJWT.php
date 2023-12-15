<?php
    use Firebase\JWT\JWT;

    function createCSRFJWT() {
        $currentTime = time();
        $expirationTime = $currentTime + 300;
        $key = $_ENV["JWT_SECRET"];
        $payload = [
            'iss' => 'anterkuy',
            'aud' => 'csrf',
            'iat' => $currentTime,
            'nbf' => $expirationTime
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }
?>