<?php
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;


require "./src/utilities/JWT/SessionResetSecret.php";
require "./src/utilities/JWT/CSRFSecret.php";
require "./src/utilities/JWT/SessionSecret.php";
require "./src/utilities/JWT/index.php";
require "./src/utilities/Security/EncryptDecrypt.php";
require __DIR__ . '/vendor/autoload.php';

$renderer = new PhpRenderer(__DIR__ . '/src/views');
$app = AppFactory::create();

$app->addRoutingMiddleware();

$customErrorHandler = function () use ($app, $renderer) {
     $response = $app->getResponseFactory() -> createResponse();
     $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
     $iv = $_ENV["COOKIE_SECRET_IV"];

     $sessionCookie = [
         'expired' => true
     ];
        
     if (isset($_COOKIE['session'])) {
         $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
     }
     return $renderer->render($response, "error/404.php", [
         "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
     ]);
};

$errorMiddleware = $app -> addErrorMiddleware(true, true, true);
$errorMiddleware -> setDefaultErrorHandler($customErrorHandler);

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch(Exception $e) { }

$routes = require __DIR__ . '/src/index.php';
$routes($app, $renderer);

$app->run()
?>
