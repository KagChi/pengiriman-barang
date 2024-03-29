<?php

use Slim\App;

return function (App $app, $renderer) use ($connection) {
    $apiRoutes = require './src/api/account/index.php';
    $apiRoutes($app, $renderer);

    $apiPackageRoutes = require './src/api/package/index.php';
    $apiPackageRoutes($app, $renderer);
}

?>
