<?php
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/vendor/autoload.php';

$isApache = false;

if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) {
    $isApache = true;
} else {
    $isApache = false;
}

$projectName = basename(__DIR__);
$renderer = new PhpRenderer(__DIR__ . '/src/views');
$app = AppFactory::create();

$app->addRoutingMiddleware();

$customErrorHandler = function () use ($app, $renderer) {
    $response = $app->getResponseFactory() -> createResponse();
    return $renderer->render($response, "error/404.php");
};

$errorMiddleware = $app -> addErrorMiddleware(true, true, true);
$errorMiddleware -> setDefaultErrorHandler($customErrorHandler);

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch(Exception $e) { }

$app->get($isApache ? "/$projectName/" : "/", function ($request, $response, $args) use ($renderer) {
    return $renderer->render($response, "index.php", $args);
})->setName('home');

$app->get($isApache ? "/$projectName/account" : "/account", function ($request, $response, $args) use ($renderer) {
    $refCode = array_key_exists("ref", $request->getQueryParams()) ? $request->getQueryParams()["ref"] : "unknown";

    if ($refCode === "register") {
        return $renderer->render($response, "/account/register.php");
    } else if ($refCode === "login") {
        return $renderer->render($response, "/account/login.php");
    }
    return $renderer->render($response, "/account/index.php");
})->setName('account');

$app->run()
?>