<?php
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/vendor/autoload.php';

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

$routes = require __DIR__ . '/src/index.php';
$routes($app, $renderer, $projectName);

$app->run()
?>