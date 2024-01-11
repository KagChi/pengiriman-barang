<?php

use Slim\App;
use Hidehalo\Nanoid\Client;

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

    $app->get("/reset", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $token = array_key_exists("token", $request->getQueryParams()) ? $request->getQueryParams()["token"] : "unknown";
        $result = $connection->query("SELECT `user_id` FROM `password_reset` WHERE `token` = ('$token');");
        if ($result) {
            if ($result->num_rows > 0) {
                return $renderer->render($response, "/account/reset_password.php", [
                    "csrf" => $csrf,
                    "token" => $token
                ]);
            }
        }

        return $renderer->render($response, "/account/reset.php", [
            "csrf" => $csrf
        ]);
    })->setName('account_reset');

    $app->get("/logout", function ($request, $response, $args) use ($renderer) {
        if (isset($_COOKIE['session'])) {
            setcookie("session", "", time() - 3600);
        }

        return $response->withHeader('Location', '/home')->withStatus(302);
    });

    $app->get("/dashboard", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/dashboard/')->withStatus(302);
    });

    $app->get("/dashboard/", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $user_id = $sessionCookie["info"]->user_id;


        $result = $connection->query("SELECT `role`, `first_name` FROM `user` WHERE `id` = ('$user_id');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $onGoingCount = 0;
                $onHoldCount = 0;
                $returnCount = 0;
                $doneCount = 0;

                $countResult = $connection->query("SELECT COUNT(*) AS count FROM `package` WHERE `user_id` = ('$user_id') AND `state` = ('on_going')");
                if ($countResult) {
                    $countRow = $countResult->fetch_assoc();
                    $onGoingCount = $countRow['count'];
                }

                $countResult = $connection->query("SELECT COUNT(*) AS count FROM `package` WHERE `user_id` = ('$user_id') AND `state` = ('on_hold')");
                if ($countResult) {
                    $countRow = $countResult->fetch_assoc();
                    $onHoldCount = $countRow['count'];
                }

                $countResult = $connection->query("SELECT COUNT(*) AS count FROM `package` WHERE `user_id` = ('$user_id') AND `state` = ('return')");
                if ($countResult) {
                    $countRow = $countResult->fetch_assoc();
                    $returnCount = $countRow['count'];
                }

                $countResult = $connection->query("SELECT COUNT(*) AS count FROM `package` WHERE `user_id` = ('$user_id') AND `state` = ('done')");
                if ($countResult) {
                    $countRow = $countResult->fetch_assoc();
                    $doneCount = $countRow['count'];
                }

                $currentHour = date('G');

                if ($currentHour >= 5 && $currentHour < 12) {
                    $timeOfDay = 'Pagi';
                } elseif ($currentHour >= 12 && $currentHour < 14) {
                    $timeOfDay = 'Siang';
                } elseif ($currentHour >= 15 && $currentHour < 20) {
                    $timeOfDay = 'Sore';
                } else {
                    $timeOfDay = 'Malam';
                }

                $packageRow = [];

                $package = $connection->query("SELECT `name`, `state`, `resi` FROM `package` WHERE `user_id` = ('$user_id') ORDER BY `package`.`date` ASC;");
                if ($package->num_rows > 0) {
                    $packageRow = $package->fetch_assoc();
                }

                return $renderer->render($response, "/dashboard/index.php", [
                    "csrf" => $csrf,
                    "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                    'role' => $row["role"],
                    'name' => $row["first_name"],
                    'time' => $timeOfDay,
                    'package' => $packageRow,
                    'onGoingCount' => $onGoingCount,
                    'onHoldCount' => $onHoldCount,
                    'returnCount' => $returnCount,
                    'doneCount' => $doneCount
                ]);
            }
        }

        // That user probably was deleted, reset their cookie.
        setcookie("session", "", time() - 3600);

        return $response->withHeader('Location', '/login')->withStatus(302);
    });

    $app->post("/dashboard/kirim", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $user_id = $sessionCookie["info"]->user_id;

        $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $client = new Client();

                $resi = $client->formattedId("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 11);
                $price = 0;

                $name = $_POST["name"];
                $city = $_POST["city"];
                $district = $_POST["district"];
                $receiver = $_POST["receiver"];
                $address = $_POST["address"];
                $type = $_POST["type"];
                $count = $_POST["count"];
                $weight = $_POST["weight"];
                $notes = $_POST["notes"];

                $isCargo = $weight > 8;

                if ($type === "fast") {
                    $price = ($weight * ($isCargo ? 15000 : 9000)) * $count;
                } else if ($type === "same_day") {
                    $price = ($weight * ($isCargo ? 25000 : 15000)) * $count;
                } else if ($type === "instant") {
                    $price = ($weight * ($isCargo ? 35000 : 25000)) * $count;
                }

                $result = $connection->query("INSERT INTO `package`(`user_id`, `resi`, `type`, `receiver`, `state`, `name`, `city`, `district`, `address`, `count`, `weight`, `notes`, `price`) VALUES ('$user_id','$resi','$type','$receiver','on_going','$name','$city','$district','$address','$count','$weight','$notes', '$price')");
                if ($result) {
                    return $renderer->render($response, "/dashboard/send/process.php", [
                        "csrf" => $csrf,
                        "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                        'role' => $row["role"],
                        'resi' => $resi,
                        'price' => $price
                    ]);
                } else {
                    // TODO: DIRECT TO ERROR PAGE
                    return $response->withHeader('Location', '/error')->withStatus(302);
                }
            }
        }

        // That user probably was deleted, reset their cookie.
        setcookie("session", "", time() - 3600);

        return $response->withHeader('Location', '/login')->withStatus(302);
    });

    $app->get("/dashboard/kirim", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/dashboard/kirim/')->withStatus(302);
    });

    $app->get("/dashboard/kirim/", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $user_id = $sessionCookie["info"]->user_id;

        $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                return $renderer->render($response, "/dashboard/send/index.php", [
                    "csrf" => $csrf,
                    "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                    'role' => $row["role"]
                ]);
            }
        }

        // That user probably was deleted, reset their cookie.
        setcookie("session", "", time() - 3600);

        return $response->withHeader('Location', '/login')->withStatus(302);
    });

    $app->get("/dashboard/lacak", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/dashboard/lacak/')->withStatus(302);
    });

    $app->get("/dashboard/lacak/", function ($request, $response, $args) use ($renderer, $connection) {
        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $sessionCookie = [
            'expired' => true
        ];

        $role = 0;

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
            $user_id = $sessionCookie["info"]->user_id;

            $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $role = $row["role"];
                }
            }
        }

        return $renderer->render($response, "/dashboard/locate/index.php", [
            "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
            'role' => $role
        ]);
    });

    $app->post("/dashboard/lacak", function ($request, $response, $args) use ($renderer, $connection) {
        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $sessionCookie = [
            'expired' => true
        ];

        $role = 0;

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
            $user_id = $sessionCookie["info"]->user_id;

            $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $role = $row["role"];
                }
            }
        }

        $parsedBody = $request->getParsedBody();
        $resi = $parsedBody["resi"];
        $result = $connection->query("SELECT * FROM `package` WHERE `resi` = ('$resi');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                return $renderer->render($response, "/dashboard/locate/output.php", [
                    "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                    'role' => $role,
                    "data" => $row
                ]);
            }
        }

        return $renderer->render($response, "/dashboard/locate/output.php", [
            "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
            'role' => 0
        ]);
    });

    $app->get("/dashboard/lacak/{resi}", function ($request, $response, $resi) use ($renderer, $connection) {
        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $sessionCookie = [
            'expired' => true
        ];

        $role = 0;

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
            $user_id = $sessionCookie["info"]->user_id;

            $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $role = $row["role"];
                }
            }
        }

        $resi = $request->getAttribute('resi');
        $result = $connection->query("SELECT * FROM `package` WHERE `resi` = ('$resi');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                return $renderer->render($response, "/dashboard/locate/output.php", [
                    "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                    'role' => $role,
                    "data" => $row
                ]);
            }
        }

        return $renderer->render($response, "/dashboard/locate/output.php", [
            "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
            'role' => $role
        ]);
    });

    $app->get("/dashboard/kiriman", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/dashboard/kiriman/')->withStatus(302);
    });

    $app->get("/dashboard/kiriman/", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $user_id = $sessionCookie["info"]->user_id;

        $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id');");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $result = $connection->query("SELECT `date`, `state`, `name`, `city`, `price`, `resi` FROM `package` WHERE `user_id` = ('$user_id') LIMIT 10;");
                $results = [];
                while ($package = $result->fetch_assoc()) {
                    $results[] = $package;
                }

                return $renderer->render($response, "/dashboard/sent.php", [
                    "csrf" => $csrf,
                    "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                    'role' => $row["role"],
                    "results" => $results
                ]);
            }
        }

        // That user probably was deleted, reset their cookie.
        setcookie("session", "", time() - 3600);

        return $response->withHeader('Location', '/login')->withStatus(302);
    });

    $app->get("/admin/pengguna", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/admin/pengguna/')->withStatus(302);
    });

    $app->get("/admin/pengguna/", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $user_id = $sessionCookie["info"]->user_id;

        $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id') LIMIT 1;");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if ($row["role"] == 0) {
                    return $response->withHeader('Location', '/dashboard')->withStatus(302);
                }

                $result = $connection->query("SELECT `username`, `phone`, `email`, `role` FROM `user` LIMIT 10;");
                $results = [];
                while ($package = $result->fetch_assoc()) {
                    $results[] = $package;
                }

                return $renderer->render($response, "/dashboard/admin/users.php", [
                    "csrf" => $csrf,
                    "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                    'role' => $row["role"],
                    'results' => $results
                ]);
            }
        }

        // That user probably was deleted, reset their cookie.
        setcookie("session", "", time() - 3600);

        return $response->withHeader('Location', '/login')->withStatus(302);
    });

    $app->get("/admin/kiriman", function ($request, $response, $args) use ($renderer) {
        return $response->withHeader('Location', '/admin/kiriman/')->withStatus(302);
    });

    $app->get("/admin/kiriman/", function ($request, $response, $args) use ($renderer, $connection) {
        $csrf = createCSRFJWT();

        $encryptionKey = $_ENV["COOKIE_SECRET_KEY"];
        $iv = $_ENV["COOKIE_SECRET_IV"];

        $csrfCookie = encryptData($csrf, $encryptionKey, $iv);
        setcookie('csrf_token', $csrfCookie, time() + 300);

        $sessionCookie = [
            'expired' => true
        ];

        if (isset($_COOKIE['session'])) {
            $sessionCookie = decryptJWT(decryptData($_COOKIE['session'], $encryptionKey, $iv));
        }

        if ($sessionCookie["expired"]) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $user_id = $sessionCookie["info"]->user_id;

        $result = $connection->query("SELECT `role` FROM `user` WHERE `id` = ('$user_id') LIMIT 1;");
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if ($row["role"] == 0) {
                    return $response->withHeader('Location', '/dashboard')->withStatus(302);
                }

                $result = $connection->query("SELECT `user_id`, `date`, `state`, `name`, `city`, `price`, `resi` FROM `package` LIMIT 10;");
                $results = [];
                while ($package = $result->fetch_assoc()) {
                    $user_id = $package["user_id"];
                    $user = $connection->query("SELECT `username` FROM `user` WHERE `id` = ('$user_id');");
                    if ($user->num_rows > 0) {
                        $userRow = $user->fetch_assoc();
                        $package["user"] = $userRow["username"];
                    }
                    $results[] = $package;
                }

                return $renderer->render($response, "/dashboard/admin/sent.php", [
                    "csrf" => $csrf,
                    "sessionActive" => $sessionCookie["expired"] ? 'false' : 'true',
                    'role' => $row["role"],
                    "results" => $results
                ]);
            }
        }

        // That user probably was deleted, reset their cookie.
        setcookie("session", "", time() - 3600);

        return $response->withHeader('Location', '/login')->withStatus(302);
    });

    $apiRoutes = require './src/api/index.php';
    $apiRoutes($app, $renderer);
};
