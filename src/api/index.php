<?php

use Slim\App;

$isApache = false;

if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) {
    $isApache = true;
}

return function (App $app, $renderer, $projectName) use ($isApache, $connection) {
    $apiRoutes = require './src/api/account/index.php';
    $apiRoutes($app, $renderer, $projectName);
}

?>
