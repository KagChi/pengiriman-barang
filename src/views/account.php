<?php
    include "./src/components/head.php";
?>

<title>Halaman Akun</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col">
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "GET" && $ref === "login") {
        include "./src/components/account/login.php";
    }
    ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "GET" && $ref === "register") {
        include "./src/components/account/register.php";
    }
    ?>
</body>

</html>