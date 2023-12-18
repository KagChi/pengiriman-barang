<?php
    include "./src/components/head.php";
?>

<title>Halaman Utama</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col">
    <?php
        include "./src/components/navbar.php";
    ?>

    <div class="flex flex-col justify-center items-center w-full h-screen gap-4">
        <img class="w-96 h-96" src="/public/assets/svg/404.svg">
        <a href="/" class="flex w-42 h-10 bg-[#FF9130] rounded-md justify-center items-center text-white font-bold gap-4 px-4">
            <i class="text-white fa-solid fa-arrow-left fa-xl"></i>
            <p>
                Halaman Utama
            </p>

            <?php
            ?>
        </a>
    </div>

    <?php
        include "./src/components/footer.php";
    ?>
</body>
</html>