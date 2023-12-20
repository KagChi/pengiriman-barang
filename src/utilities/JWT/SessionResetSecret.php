<?php
    use Firebase\JWT\JWT;

    function createSessionResetJWT($userId, $email) {
        $currentTime = time();
        $expirationTime = $currentTime + (3600 * 24); // 24 Hours
        $key = $_ENV["JWT_SECRET"];
        $payload = [
            'iss' => 'anterkuy',
            'aud' => 'reset',
            'iat' => $currentTime,
            'exp' => $expirationTime,
            'user_id' => $userId,
            'email' => $email
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }
?>