<?php

use Slim\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

return function (App $app, $renderer) use ($connection) {
    $app->post("/api/account/create", function ($request, $response, $args) use ($renderer, $connection) {
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

            if (!$sessionCookie["expired"]) {
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

    $app->post("/api/account/login", function ($request, $response, $args) use ($renderer, $connection) {
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

            if (!$sessionCookie["expired"]) {
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

    $app->post("/api/account", function ($request, $response, $args) use ($renderer, $connection) {
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

            if (!$sessionCookie["expired"]) {
                $data["message"] = "Terdeteksi sudah login !";
                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }

        $token = decryptJWT(decryptData($parsedBody["token"], $encryptionKey, $iv));

        if ($token["expired"]) {
            $data["message"] = "Token reset anda tidak valid, tolong muat kembali !";
            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);
            $token = $parsedBody["token"];

            $result = $connection->query("SELECT `id` FROM `password_reset` WHERE `token` = ('$token');");
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $result->free();
                    $id = $row["id"];
                    $connection -> query("DELETE FROM `password_reset` WHERE `password_reset`.`id` = $id;");
                }
            }

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
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

        $Token = $parsedBody["token"];
        $Password = password_hash($parsedBody["password"], PASSWORD_DEFAULT);

        if ($parsedBody["password"] !== $parsedBody["konfirmasi_password"]) {
            $data["message"] = "Password konfirmasi anda tidak sama !";

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $result = $connection->query("SELECT COUNT(*) AS count FROM `password_reset` WHERE `token` = '$Token'");

        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['count'];

            if ($count <= 0) {
                $data["message"] = "Token reset tidak valid !";

                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $connection->close();
                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }

        $result = $connection->query("SELECT `user_id`, `id` FROM `password_reset` WHERE `token` = ('$Token');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $result->free();
                $id = $row["user_id"];
                $result = $connection->query("UPDATE `user` SET `password` = '$Password' WHERE `user`.`id` = $id;");
                if ($result) {
                    $data["message"] = "Password sukses di update !";
                    $data["status"] = "success";
                    $data["success"] = true;

                    $id = $row["id"];
                    $connection -> query("DELETE FROM `password_reset` WHERE `password_reset`.`id` = $id;");

                    $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                    $connection->close();
                    $response->getBody()->write($jsonResponse);
                    return $response->withHeader('Content-Type', 'application/json');
                } 
            }
        } else {
            $data["message"] = "Kesalahan, coba lagi nanti !";

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $connection->close();
            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    })->setName("account_create_api");

    $app->post("/api/account/reset", function ($request, $response, $args) use ($renderer, $connection) {
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

            if (!$sessionCookie["expired"]) {
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
        $result = $connection->query("SELECT COUNT(*) AS count FROM `user` WHERE `email` = '$Email'");

        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['count'];

            if ($count <= 0) {
                $data["message"] = "Akun tidak di temukan !";

                $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                $connection->close();
                $response->getBody()->write($jsonResponse);
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }

        $result = $connection->query("SELECT `id` FROM `user` WHERE `email` = ('$Email');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $result->free();
                $id = $row["id"];
                $token = encryptData(createSessionResetJWT($id, $Email), $encryptionKey, $iv);
                $host = $_ENV["HOST"];

                $result = $connection->query("INSERT INTO `password_reset`(`token`, `user_id`) VALUES ('$token','$id')");
                if ($result) {

                    try {
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();

                        $mail->Host = $_ENV["SMTP_HOST"];
                        $mail->SMTPAuth = true;
                        $mail->Username = $_ENV["SMTP_USERNAME"];
                        $mail->Password = $_ENV["SMTP_PASSWORD"];
                        $mail->Port = $_ENV["SMTP_PORT"];

                        $mail->setFrom('no-reply@anterkuy.id', 'No Reply - AnterKuy Password Reset');
                        $mail->addAddress($Email);

                        $mail->isHTML(true);
                        $mail->Subject = 'AnterKuy Password Reset';
                        $mail->Body    = "Reset password anda, klik <a href='$host/reset?token=$token'>link</a> ini";

                        $mail->send();

                        $data["message"] = "Link password reset sukses di kirim !";
                        $data["status"] = "success";
                        $data["success"] = true;

                        $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                        $connection->close();
                        $response->getBody()->write($jsonResponse);
                        return $response->withHeader('Content-Type', 'application/json');
                    } catch (Exception $e) {
                        $data["message"] = $mail->ErrorInfo;

                        $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

                        $connection->close();
                        $response->getBody()->write($jsonResponse);
                        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
                    }
                }
            }
        } else {
            $data["message"] = "Kesalahan, coba lagi nanti !";

            $jsonResponse = json_encode($data, JSON_PRETTY_PRINT);

            $connection->close();
            $response->getBody()->write($jsonResponse);
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    })->setName("account_reset_api");
}

?>