<?php
    include "./src/components/database/connection.php";
?>

<?php
    $page = "";  
    switch (substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"],"/") + 1)) {
        case "index.php":
            $page = "home";
            break;
        case "account.php":
            $page = "account";
            break;

        default:
            $page = "unknown";
            break;
    }

    $ref = "";
    if (isset($_GET["ref"])) {
        $ref = $_GET["ref"];
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Script's -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="./public/assets/script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Cascading Style Sheet's -->
    <link rel="stylesheet" href="./public/assets/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/transition-style">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="icon" type="image/x-icon" href="./public/assets/images/icon.png">
</head>