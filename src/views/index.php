<?php
include "./src/components/head.php";
?>

<title>Halaman Utama</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col dark:bg-[#121212] overflow-x-hidden">
    <?php
    include "./src/components/navbar.php";
    ?>

    <main class="2xl:mx-auto">
        <section class="h-auto flex justify-center items-center">
            <div class="px-4 pt-32 flex flex-col md:flex-row mb-20 gap-4">
                <div data-aos="fade-right" class="w-full md:pl-14 md:w-1/2 pt-8 flex flex-col px-3">
                    <div class="flex flex-row md:flex-col gap-1 md:pt-10 lg:pt-12">
                        <span class="text-4xl md:text-5xl lg:text-7xl font-extrabold flex flex-row gap-1 md:gap-5 text-[#22092C] dark:text-[#FCFCFC]">Mau <p class="text-[#FF9130]">Kirim</p></span>
                        <span class="text-4xl md:text-5xl lg:text-7xl font-extrabold flex flex-row gap-1 md:gap-5 text-[#22092C] dark:text-[#FCFCFC]">
                            <p class="text-[#FF9130]">Apa</p> Nih?
                        </span>
                    </div>
                    <p class="pt-4 text-sm md:text-xl text-[#22092C] dark:text-[#FCFCFC]">Murah, Aman, Cepat, dan Terpercaya.</p>

                    <a href="/dashboard/kirim" class="mt-2 transition delay-150 duration-300 hover:scale-110 ease-in-out flex flex-row w-52 items-center justify-center gap-2 h-10 bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130] text-[#FCFCFC] rounded-md text-xl mt-4 shadow-2xl px-3 py-6">
                        <i class="fa-solid fa-paper-plane"></i>
                        <p>Kirim Sekarang</p>
                    </a>
                </div>

                <div data-aos="fade-left" class="w-full lg:h-[500px] lg:w-[780px] pt-8 md:pt-0">
                    <img class="ml-auto shadow-2xl rounded-lg aspect-[3/2]" src="/public/assets/images/home.jpg">
                </div>
            </div>
        </section>

        <section data-aos="fade-up" class="grid grid-cols-1 w-full px-4 justify-center gap-6">
            <div class="grid grid-cols-1 text-center">
                <p class="text-[#22092C] dark:text-[#FCFCFC] text-2xl md:text-4xl font-bold">
                    Jaringan Kami
                </p>

                <p class="text-xs md:text-base text-[#22092C] dark:text-[#FCFCFC]">
                    Perusahaan yang mempercayai kami lebih dari sekedar pengiriman
                </p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 place-items-center px-4 md:px-12 lg:px-32">
                <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/bukalapak.svg">
                <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/shopee.svg">
                <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/tokped.svg">
                <img class="h-24 md:h-32" src="/public/assets/svg/e-commerce/blibli.svg">
            </div>
        </section>

        <section data-aos="fade-up" class="flex flex-col px-4 md:px-12 lg:px-32 w-full mt-20">
            <div class="grid grid-cols-1 text-center">
                <p class="text-[#22092C] dark:text-[#FCFCFC] text-2xl md:text-4xl font-bold">
                    Keunggulan Kami
                </p>

                <p class="text-xs md:text-base text-[#22092C] dark:text-[#FCFCFC]">
                    Kami mempunyai beberapa keunggulan untuk kepentingan pelanggan
                </p>
            </div>
            <div class="flex flex-col justify-between md:flex-row md:mt-12">
                <img class="hidden lg:flex h-72 md:h-96" src="/public/assets/svg/feature.svg">
                <div class="flex flex-col gap-4 w-full lg:w-[32rem] justify-center items-center mt-8 lg:mt-0">
                    <div class="flex flex-row gap-6 w-full">
                        <div class="flex bg-[#EE7214] rounded-full w-[3.6rem] h-[3.6rem] items-center justify-center">
                            <i class="fa-solid fa-truck-fast fa-xl text-white"></i>
                        </div>
                        <div class="flex flex-col w-3/4">
                            <p class="font-bold text-2xl dark:text-white">Gratis Jemput</p>
                            <p class="inline-block dark:text-white">Berapapun kiriman paketnya, kami jemput tanpa biaya tambahan</p>
                        </div>
                    </div>

                    <div class="flex flex-row gap-6 w-full">
                        <div class="flex bg-[#EE7214] rounded-full w-[3.6rem] h-[3.6rem] items-center justify-center">
                            <i class="fa-solid fa-hand-holding-dollar fa-xl text-white"></i>
                        </div>
                        <div class="flex flex-col w-3/4">
                            <p class="font-bold text-2xl dark:text-white">Tarif Terbaik</p>
                            <p class="inline-block dark:text-white">Kami memastikan tarif terbaik untuk pelanggan kami</p>
                        </div>
                    </div>

                    <div class="flex flex-row gap-6 w-full">
                        <div class="flex bg-[#EE7214] rounded-full w-[3.6rem] h-[3.6rem] items-center justify-center">
                            <i class="fa-solid fa-clock-rotate-left fa-xl text-white"></i>
                        </div>
                        <div class="flex flex-col w-3/4">
                            <p class="font-bold text-2xl dark:text-white">Tanpa Hambatan</p>
                            <p class="inline-block dark:text-white">Kami memastikan untuk tidak ada hambatan dalam pengiriman untuk pelanggan kami</p>
                        </div>
                    </div>

                    <div class="flex flex-row gap-6 w-full">
                        <div class="flex bg-[#EE7214] rounded-full w-[3.6rem] h-[3.6rem] items-center justify-center">
                            <i class="fa-solid fa-shield-halved fa-xl text-white"></i>
                        </div>
                        <div class="flex flex-col w-3/4">
                            <p class="font-bold text-2xl dark:text-white">Paling Aman</p>
                            <p class="text-wrap dark:text-white">Kami memastikan untuk menjaga keamanan dan kerahasiaan pelanggan kami</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" class="flex flex-col px-4 md:px-12 lg:px-32 w-full mt-20 mb-20">
            <div class="grid grid-cols-1 text-center">
                <p class="text-[#22092C] dark:text-[#FCFCFC] text-2xl md:text-4xl font-bold">
                    Testimonials
                </p>

                <p class="text-xs md:text-base text-[#22092C] dark:text-[#FCFCFC]">
                    Kami memperdulikan feedback dari pelanggan, itu adalah pelajaran bagi kami
                </p>
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col justify-center items-center md:justify-between md:flex-row mt-12 gap-4">
                    <div class="bg-[#EEEEEE] dark:bg-[#252525] w-80 md:w-96 h-48 p-6 rounded-xl flex flex-col shadow-xl">
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <p class="dark:text-white font-bold">Jeanice Nayuki</p>
                                <p class="dark:text-white text-xs">⭐ 5/5</p>
                            </div>
                            <img class="w-12 h-12 rounded-full" src="https://i.pravatar.cc/?u=a04258dw2342">
                        </div>
                        <div>
                            <p class="mt-4 dark:text-white text-sm">Selalu tepat waktu, ekspedisi yang dapat diandalkan.</p>
                            <div class="border border-2 border-[#FF9130] rounded-full w-2/3 mt-4"></div>
                        </div>
                    </div>

                    <div class="bg-[#EEEEEE] dark:bg-[#252525] w-80 md:w-96 h-48 p-6 rounded-xl hidden lg:flex flex-col shadow-xl">
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <p class="dark:text-white font-bold">Sayutie Huyuki</p>
                                <p class="dark:text-white text-xs">⭐ 4/5</p>
                            </div>
                            <img class="w-12 h-12 rounded-full" src="https://i.pravatar.cc/150?img=5">
                        </div>
                        <div>
                            <p class="mt-4 dark:text-white text-sm">Kemasan rapi, barang terjaga dengan baik selama pengiriman.</p>
                            <div class="border border-2 border-[#FF9130] rounded-full w-2/3 mt-4"></div>
                        </div>
                    </div>

                    <div class="bg-[#EEEEEE] dark:bg-[#252525] w-80 md:w-96 h-48 p-6 rounded-xl flex flex-col shadow-xl">
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <p class="dark:text-white font-bold">John Klavoskie</p>
                                <p class="dark:text-white text-xs">⭐ 5/5</p>
                            </div>
                            <img class="w-12 h-12 rounded-full" src="https://i.pravatar.cc/150?img=57">
                        </div>
                        <div>
                            <p class="mt-4 dark:text-white text-sm">Pengiriman barang sangat lancar, pasti akan menggunakan lagi di masa depan.</p>
                            <div class="border border-2 border-[#FF9130] rounded-full w-2/3 mt-4"></div>
                        </div>
                    </div>
                </div>
                <div class="flex lg:hidden w-full justify-center items-center">
                    <div class="bg-[#EEEEEE] dark:bg-[#252525] w-80 md:w-96 h-48 p-6 rounded-xl flex flex-col shadow-xl">
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <p class="dark:text-white font-bold">Yovie Voxie</p>
                                <p class="dark:text-white text-xs">⭐ 4/5</p>
                            </div>
                            <img class="w-12 h-12 rounded-full" src="https://i.pravatar.cc?u=a042581f4e29026704d">
                        </div>
                        <div>
                            <p class="mt-4 dark:text-white text-sm">Aman dan terpercaya, barang sampai dengan kondisi sempurna.</p>
                            <div class="border border-2 border-[#FF9130] rounded-full w-2/3 mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="relative z-[100]">
        <a onclick="changeTheme()" id="darkModeToggler" class="cursor-pointer flex justify-center items-center h-14 w-14 bg-[#22092C] dark:bg-[#FF9130] rounded-full text-white p-2 fixed bottom-0 right-0 mb-6 mr-4">
            <i id="darkModeTogglerIcon" class="fa-solid fa-moon fa-xl"></i>
        </a>
    </div>

    <?php
    include "./src/components/footer.php";
    ?>
</body>

</html>