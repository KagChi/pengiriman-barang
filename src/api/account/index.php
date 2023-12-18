<?php

use Slim\App;

$isApache = false;

if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) {
    $isApache = true;
}

return function (App $app, $renderer, $projectName) use ($isApache, $connection) {
    $app->post($isApache ? "/$projectName/api/account/create" : "/api/account/create", function ($request, $response, $args) use ($renderer, $connection) {
        $parsedBody = $request->getParsedBody();

        $data = [
            'message' => 'Kesalahan tidak diketahui !',
            'status' => 'failed',
            'success' => false
        ];
        
        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));

            if ($sessionCookie["token"]) {
                $data["message"] = "Terdeteksi sudah login !";
                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }

        if (isset($_COOKIE['csrf_token'])) {
            $csrfCookie = decryptJWT(decryptData($_COOKIE['csrf_token'], $encryptionKey, $iv));

            if (!$csrfCookie["expired"] && $csrfCookie["token"] !== $parsedBody["csrf_token"]) {
                $data["message"] = "Token CSRF anda tidak valid, tolong muat kembali !";
                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        } else {
            $data["message"] = "Token CSRF anda tidak valid, tolong muat kembali !";
            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $Username = $parsedBody["username"];
        $FirstName = $parsedBody["first_name"];
        $LastName = $parsedBody["last_name"];
        $Email = $parsedBody["email"];
        $Phone = $parsedBody["phone"];
        $Password = password_hash($parsedBody["password"], PASSWORD_DEFAULT);

        if ($parsedBody["password"] !== $parsedBody["konfirmasi_password"]) {
            $data["message"] = "Password konfirmasi anda tidak sama !";

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $result = $connection->query("SELECT COUNT(*) AS count FROM `user` WHERE `email` = '$Email' OR `phone` = '$Phone'");

        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['count'];

            if ($count >= 1) {
                $data["message"] = "Akun sudah pernah di daftarkan !";

                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $connection->close();
                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }

        $result = $connection->query("INSERT INTO `user`(`username`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES ('$Username','$FirstName','$LastName','$Email','$Phone','$Password')");
        if ($result) {
            $data["message"] = "Akun sukses di daftarkan !";
            $data["status"] = "success";
            $data["success"] = true;

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $connection->close();
            $response->getBody()->write($jsonResponse);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $data["message"] = "Kesalahan, coba lagi nanti !";

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $connection->close();
            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    })->setName("account_create_api");

    $app->post($isApache ? "/$projectName/api/account/login" : "/api/account/login", function ($request, $response, $args) use ($renderer, $connection) {
        $parsedBody = $request->getParsedBody();

        $data = [
            'message' => 'Kesalahan tidak diketahui !',
            'status' => 'failed',
            'success' => false
        ];

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));

            if ($sessionCookie["token"]) {
                $data["message"] = "Terdeteksi sudah login !";
                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }

        if (isset($_COOKIE['csrf_token'])) {
            $csrfCookie = decryptJWT(decryptData($_COOKIE['csrf_token'], $encryptionKey, $iv));

            if (!$csrfCookie["expired"] && $csrfCookie["token"] !== $parsedBody["csrf_token"]) {
                $data["message"] = "Token CSRF anda tidak valid, tolong muat kembali !";
                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        } else {
            $data["message"] = "Token CSRF anda tidak valid, tolong muat kembali !";
            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $Email = $parsedBody["email"];

        $result = $connection->query("SELECT `password`, `id`, `username` FROM `user` WHERE `email` = ('$Email');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $result->free();
                $Status = password_verify($parsedBody["password"], $row["password"]);

                if ($Status) {
                    $data["message"] = "Login sukses !";
                    $data["status"] = "success";
                    $data["success"] = $Status;

                    $JWTToken = createSessionJWT($row["id"], $row["username"]);
                    $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
                    $iv = $_ENV["COOKIE_SECRET_IV"];

                    setcookie("session", encryptData($JWTToken, $encryptionKey, $iv), time() + 5 * 60 * 60, "/");

                    $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                    $connection->close();
                    $response->getBody()->write($jsonResponse);
                    return $response->withHeader('Content-Type', 'application/json');
                }
            }
            $data["message"] = "Akun tidak ditemukan !";

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $connection->close();
            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } else {
            $data["message"] = "Kesalahan, coba lagi nanti !";

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $connection->close();
            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    })->setName("account_login_api");
}

?>