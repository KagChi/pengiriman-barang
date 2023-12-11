<?php
    include "./components/head.php";
?>


<!DOCTYPE html>
<html lang="en">

<body>
    <?php
        include "./components/navbar.php";
    ?>
    <section class="pl-4 pr-4 md:pr-0 md:pl-12 pt-32 flex flex-col md:flex-row mb-20 gap-4">
        <div class="w-full md:w-1/2 pt-8 flex flex-col px-3">
            <div class="flex flex-row md:flex-col gap-1">
                <span class="text-4xl md:text-5xl lg:text-7xl font-bold flex flex-row gap-1 md:gap-5 text-[#22092C]">Mau <p class="text-[#FF9130]">Kirim</p></span>
                <span class="text-4xl md:text-5xl lg:text-7xl font-bold flex flex-row gap-1 md:gap-5 text-[#22092C]"><p class="text-[#FF9130]">Apa</p> Nih?</span>
            </div>
            <p class="pt-4 text-sm md:text-xl text-[#22092C]">Murah, Aman, Cepat, dan Terpercaya.</p>

            <button class="flex flex-row w-52 items-center justify-center gap-2 h-10 hover:bg-[#EE7214] bg-[#FF9130] text-[#FCFCFC] rounded-md text-xl mt-4 shadow-2xl px-3 py-6">
                <i class="fa-solid fa-paper-plane"></i>
                <p>Kirim Sekarang</p>
            </button>
        </div>

        <div class="w-full pl-3 pr-3 md:pr-0">
            <img class="rounded-l-lg rounded-r-lg md:rounded-l-[4rem] md:rounded-r-none aspect-[10/8]" src="./assets/images/home.jpg">
        </div>
    </section>
</body>
</html>