<?php

use Slim\App;

require "./src/utilities/JWT/createCSRFJWT.php";

$isApache = false;

if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) {
    $isApache = true;
}

return function (App $app, $renderer, $projectName) use ($isApache) {
    $app->get($isApache ? "/$projectName/" : "/", function ($request, $response, $args) use ($renderer) {
        return $renderer->render($response, "index.php", $args);
    })->setName('home');
    
    $app->get($isApache ? "/$projectName/account" : "/account", function ($request, $response, $args) use ($renderer) {
        $refCode = array_key_exists("ref", $request->getQueryParams()) ? $request->getQueryParams()["ref"] : "unknown";
        $csrf = createCSRFJWT();
    
        if ($refCode === "register") {
            return $renderer->render($response, "/account/register.php", [
                "csrf" => $csrf
            ]);
        } else if ($refCode === "login") {
            return $renderer->render($response, "/account/login.php", [
                "csrf" => $csrf
            ]);
        }
        return $renderer->render($response, "/account/index.php", [
            "csrf" => $csrf
        ]);
    })->setName('account');

    // $app->get($isApache ? "/$projectName/api/csrf" : "/api/csrf", function ($request, $response, $args) use ($renderer) {

    // }
};
