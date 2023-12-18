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

    $app->get("/account", function ($request, $response, $args) use ($renderer) {
        $refCode = array_key_exists("ref", $request->getQueryParams()) ? $request->getQueryParams()["ref"] : "unknown";
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        if ($refCode === "register") {
            return $renderer->render($response, "/account/register.php", [
                "csrf" => $csrf
            ]);
        } else if ($refCode === "login") {
            return $renderer->render($response, "/account/login.php", [
                "csrf" => $csrf
            ]);
        } else if ($refCode === "reset") {
            return $renderer->render($response, "/account/reset.php", [
                "csrf" => $csrf
            ]);
        }
        return $renderer->render($response, "/account/index.php", [
            "csrf" => $csrf
        ]);
    })->setName('account');

    $apiRoutes = require './src/api/index.php';
    $apiRoutes($app, $renderer);
};
