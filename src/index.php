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

    $app->get("/reset", function ($request, $response, $args) use ($renderer) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        return $renderer->render($response, "/account/reset.php", [
            "csrf" => $csrf
        ]);
    })->setName('account_reset');

    $apiRoutes = require './src/api/index.php';
    $apiRoutes($app, $renderer);
};
