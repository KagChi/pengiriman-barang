<?php
include "./src/components/head.php";
?>

<title>Halaman Akun</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col">
    <?php
    include "./src/components/navbar.php";
    ?>

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

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && $ref === "register") {
        $Username = $_POST["username"];
        $FirstName = $_POST["first_name"];
        $LastName = $_POST["last_name"];
        $Email = $_POST["email"];
        $Phone = $_POST["phone"];
        $Password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $Result = $connection->query("SELECT * FROM `user` WHERE `email` = '$Email' OR `phone` = '$Phone'");

        if ($Result->num_rows > 0) {
            $success = false;
            include "./src/components/account/register.php";
        } else {
            $sql = "INSERT INTO `user`(`username`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES ('$Username','$FirstName','$LastName','$Email','$Phone','$Password')";
            if ($connection->query($sql)) {
                $success = true;
                include "./src/components/account/register.php";
            } else {
                $success = false;
                include "./src/components/account/register.php";
            }
        }
        $connection->close();
    }
    ?>

    <?php
        include "./src/components/footer.php";
    ?>
</body>

</html>