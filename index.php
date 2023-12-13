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

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch(Exception $e) { }

$app->get($isApache ? "/$projectName/" : "/", function ($request, $response, $args) use ($renderer) {
    return $renderer->render($response, "index.php", $args);
})->setName('home');

$app->get($isApache ? "/$projectName/account" : "/account", function ($request, $response, $args) use ($renderer) {
    return $renderer->render($response, "account.php");
})->setName('account');

$app->run()
?>