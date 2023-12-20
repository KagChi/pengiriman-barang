<?php
    include "./src/components/head.php";
?>

<title>Halaman Utama</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col dark:bg-[#121212]">
    <?php
        include "./src/components/navbar.php";
    ?>
    <section class="md:min-h-screen flex justify-center items-center">
        <div class="px-4 pt-32 flex flex-col md:flex-row mb-20 gap-4">
            <div class="w-full md:pl-14 md:w-1/2 pt-8 flex flex-col px-3">
                <div class="flex flex-row md:flex-col gap-1 md:pt-10 lg:pt-12">
                    <span class="text-4xl md:text-5xl lg:text-7xl font-extrabold flex flex-row gap-1 md:gap-5 text-[#22092C] dark:text-[#FCFCFC]">Mau <p class="text-[#FF9130]">Kirim</p></span>
                    <span class="text-4xl md:text-5xl lg:text-7xl font-extrabold flex flex-row gap-1 md:gap-5 text-[#22092C] dark:text-[#FCFCFC]"><p class="text-[#FF9130]">Apa</p> Nih?</span>
                </div>
                <p class="pt-4 text-sm md:text-xl text-[#22092C] dark:text-[#FCFCFC]">Murah, Aman, Cepat, dan Terpercaya.</p>
    
                <a href="/dashboard/order" class="flex flex-row w-52 items-center justify-center gap-2 h-10 bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130] text-[#FCFCFC] rounded-md text-xl mt-4 shadow-2xl px-3 py-6">
                    <i class="fa-solid fa-paper-plane"></i>
                    <p>Kirim Sekarang</p>
                </a>
            </div>
    
            <div class="w-full lg:h-[500px] lg:w-[780px] pt-8 md:pt-0">
                <img class="ml-auto shadow-2xl rounded-lg aspect-[3/2]" src="/public/assets/images/home.jpg">
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 w-full px-4 mb-16 justify-center gap-6">
        <div class="grid grid-cols-1 text-center">
            <p class="text-[#22092C] dark:text-[#FCFCFC] text-2xl md:text-4xl font-bold">
                Jaringan Kami
            </p>

            <p class="text-xs md:text-base text-[#22092C] dark:text-[#FCFCFC]">
                Perusahaan yang mempercayai kami lebih dari sekedar pengiriman
            </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 place-items-center px-4 md:px-32">
            <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/bukalapak.svg">
            <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/shopee.svg">
            <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/tokped.svg">
            <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/blibli.svg">
        </div>
    </div>

    <div class="relative">
        <a onclick="changeTheme()" id="darkModeToggler" class="cursor-pointer flex justify-center items-center h-14 w-14 bg-[#22092C] dark:bg-[#FF9130] rounded-full text-white p-2 fixed bottom-0 right-0 mb-6 mr-4">
            <i id="darkModeTogglerIcon" class="fa-solid fa-moon fa-xl"></i>
        </a>
    </div>

    <?php
        include "./src/components/footer.php";
    ?>
</body>
</html>