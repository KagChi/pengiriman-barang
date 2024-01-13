<?php

use Slim\App;

return function (App $app, $renderer) use ($connection) {
    $app->post("/api/package/update", function ($request, $response, $args) use ($renderer, $connection) {
        $parsedBody = $request->getParsedBody();

        $data = [
            'message' => 'Kesalahan tidak diketahui !',
            'status' => 'failed',
            'success' => false
        ];

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $role = 0;

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));

            if ($sessionCookie["expired"]) {
                $data["message"] = "Silahkan login kembali !";
                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }

            $user_id = $sessionCookie["info"]->user_id;

            $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $role = $row["role"];
                }
            }
        } else {
            $data["message"] = "Silahkan login kembali !";
            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        // Only allow role 1 or 2 (Admin or Courir)

        if ($role == 0) {
            $data["message"] = "Tidak mempunyai akses !";
            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        if (isset($_COOKIE['csrf_token'])) {
            $csrfCookie = decryptJWT(decryptData($_COOKIE['csrf_token'], $encryptionKey, $iv));

            if (!$csrfCookie["expired"] && $csrfCookie["token"] !== $parsedBody["csrf_token"]) {
                $data["message"] = "Token CSRF anda tidak valid, tolong muat kembali !!!";
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

        $id = mysqli_real_escape_string($connection, htmlspecialchars($parsedBody["id"]));
        $state = mysqli_real_escape_string($connection, htmlspecialchars($parsedBody["state"]));
        $message = mysqli_real_escape_string($connection, htmlspecialchars($parsedBody["message"]));

        $result = $connection->query("SELECT `id` FROM `package` WHERE `id` = ('$id');");
        if ($result) {
            if ($result->num_rows > 0) {
                $connection->query("INSERT INTO `package_audit`(`package_id`, `message`, `state`) VALUES ('$id','$message','$state')");
                if ($state == "done") {
                    $connection->query("UPDATE `package` SET `state` = 'done_waiting_confirmation' WHERE id = ('$id')");
                } else if ($state == "need_action") {
                    $connection->query("UPDATE `package` SET `state` = ('$state') WHERE id = ('$id')");
                } else if ($state != "packed") {
                    $connection->query("UPDATE `package` SET `state` = 'on_going' WHERE id = ('$id')");
                }

                $data["message"] = "Sukses di update !";
                $data["success"] = true;

                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $connection->close();
                $response->getBody()->write($jsonResponse);
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            }
            $data["message"] = "Barang tidak ditemukan !";

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
    });

    $app->post("/api/package/confirm", function ($request, $response, $args) use ($renderer, $connection) {
        $parsedBody = $request->getParsedBody();

        $data = [
            'message' => 'Kesalahan tidak diketahui !',
            'status' => 'failed',
            'success' => false
        ];

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $role = 0;

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));

            if ($sessionCookie["expired"]) {
                $data["message"] = "Silahkan login kembali !";
                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }

            $user_id = $sessionCookie["info"]->user_id;

            $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $role = $row["role"];
                }
            }
        } else {
            $data["message"] = "Silahkan login kembali !";
            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        // Only allow role 1 or 2 (Admin or Courir)

        if ($role == 0) {
            $data["message"] = "Tidak mempunyai akses !";
            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        if (isset($_COOKIE['csrf_token'])) {
            $csrfCookie = decryptJWT(decryptData($_COOKIE['csrf_token'], $encryptionKey, $iv));

            if (!$csrfCookie["expired"] && $csrfCookie["token"] !== $parsedBody["csrf_token"]) {
                $data["message"] = "Token CSRF anda tidak valid, tolong muat kembali !!!";
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

        $user_id = $sessionCookie["info"]->user_id;
        $id = mysqli_real_escape_string($connection, htmlspecialchars($parsedBody["id"]));
        $state = mysqli_real_escape_string($connection, htmlspecialchars($parsedBody["state"]));

        $result = $connection->query("SELECT `id` FROM `package` WHERE `id` = ('$id') AND `user_id` = ('$user_id');");
        if ($result) {
            if ($result->num_rows > 0) {
                $message = "Unknown";

                if ($state == 'done') {
                    $message = "Paket telah di terima oleh pengguna";
                } else if ($state == 'need_action') {
                    $message = "Paket mengalami kendala";
                }

                $connection->query("INSERT INTO `package_audit`(`package_id`, `message`, `state`) VALUES ('$id','$message','$state')");
                $connection->query("UPDATE `package` SET `state` = '$state' WHERE id = ('$id')");

                $data["message"] = "Sukses di update !";
                $data["success"] = true;

                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $connection->close();
                $response->getBody()->write($jsonResponse);
                return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
            }
            $data["message"] = "Barang tidak ditemukan !";

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
    });
}

?>