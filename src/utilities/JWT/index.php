<?php
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    function decryptJWT($token) {
        $response = [
            'info' => null,
            'token' => $token,
            'expired' => true,
        ];

        try {
            $decoded = JWT::decode($token, new Key($_ENV["JWT_SECRET"], 'HS256'));
            $isExpired = (time() > $decoded->exp);
            $response = [
                'info' => $decoded,
                'token' => $token,
                'expired' => $isExpired,
            ];
        
            return $response;
        } catch (Exception $e) {
            return $response;
        }
    }
?>