<?php

use Slim\App;

require "./src/utilities/connection.php";

return function (App $app, $renderer) use ($connection) {
    $app->get("/", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/home')->withStatus(302);
    })->setName('root');

    $app->get("/home", function ($request, $response, $args) use ($renderer) {
        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $sessionCookie = [
            'expired' => true
        ];
        
        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }
        return $renderer->render($response, "index.php", [
            "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
        ]);
    })->setName('home');

    $app->get("/login", function ($request, $response, $args) use ($renderer) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        return $renderer->render($response, "/account/login.php", [
            "csrf" => $csrf
        ]);
    })->setName('account_login');

    $app->get("/register", function ($request, $response, $args) use ($renderer) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        return $renderer->render($response, "/account/register.php", [
            "csrf" => $csrf
        ]);
    })->setName('account_register');

    $app->get("/reset", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $token = array_key_exists("token", $request->getQueryParams()) ? $request->getQueryParams()["token"] : "unknown";
        $result = $connection->query("SELECT `user_id` FROM `password_reset` WHERE `token` = ('$token');");
        if ($result) {
            if ($result->num_rows > 0) {
                return $renderer->render($response, "/account/reset_password.php", [
                    "csrf" => $csrf,
                    "token" => $token
                ]);
            }
        }

        return $renderer->render($response, "/account/reset.php", [
            "csrf" => $csrf
        ]);
    })->setName('account_reset');

    $app->get("/logout", function ($request, $response, $args) use ($renderer) {
        if (isset($_COOKIE['session'])) {
            setcookie("session", "", time() - 3600);
        }

        return $response->withHeader('Location', '/home')->withStatus(302);
    })->setName('account_logout');

    $app->get("/dashboard", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/dashboard/')->withStatus(302);
    })->setName('dashboard');

    $app->get("/dashboard/", function ($request, $response, $args) use ($renderer) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];
        
        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        return $renderer->render($response, "/dashboard/index.php", [
            "csrf" => $csrf,
            "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
            'role' => $sessionCookie["info"] -> role
        ]);
    })->setName('dashboard_root');

    $app->get("/dashboard/kirim", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/dashboard/kirim/')->withStatus(302);
    })->setName('dashboard-kirim');

    $app->get("/dashboard/kirim/", function ($request, $response, $args) use ($renderer) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];
        
        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        return $renderer->render($response, "/dashboard/send.php", [
            "csrf" => $csrf,
            "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
            'role' => $sessionCookie["info"] -> role
        ]);
    })->setName('dashboard_kirim');

    $apiRoutes = require './src/api/index.php';
    $apiRoutes($app, $renderer);
};
