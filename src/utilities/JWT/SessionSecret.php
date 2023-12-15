<?php
    use Firebase\JWT\JWT;

    function createSessionJWT($userId, $username) {
        $currentTime = time();
        $expirationTime = $currentTime + 7200; // 2 Hours
        $key = $_ENV["JWT_SECRET"];
        $payload = [
            'iss' => 'anterkuy',
            'aud' => 'login',
            'iat' => $currentTime,
            'exp' => $expirationTime,
            'user_id' => $userId,
            'username' => $username
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }
?>