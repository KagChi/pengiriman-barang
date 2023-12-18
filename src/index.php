<?php

use Slim\App;

require "./src/utilities/JWT/CSRFSecret.php";
require "./src/utilities/JWT/SessionSecret.php";
require "./src/utilities/JWT/index.php";
require "./src/utilities/Security/EncryptDecrypt.php";
require "./src/utilities/connection.php";

$isApache = false;

if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) {
    $isApache = true;
}

return function (App $app, $renderer, $projectName) use ($isApache, $connection) {
    $app->get($isApache ? "/$projectName/" : "/", function ($request, $response, $args) use ($renderer) {
        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $sessionCookie = [];
        
        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }
        return $renderer->render($response, "index.php", [
            "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
        ]);
    })->setName('home');

    $app->get($isApache ? "/$projectName/account" : "/account", function ($request, $response, $args) use ($renderer) {
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
    $apiRoutes($app, $renderer, $projectName);
};
