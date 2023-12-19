<?php
include "./src/components/head.php";
?>

<title>Halaman Dashboard</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col" x-data="{ page: '<?= $page; ?>', ref: '<?= $ref; ?>', sessionActive: <?= $sessionActive; ?> }">
    <div class="flex flex-col md:flex-row">
        <div class="flex flex-col w-full bg-[#FF9130] md:w-28 lg:w-[20%] md:h-screen py-4 px-6 gap-4">
            <a href="/" class="flex flex-row justify-center items-center h-12 md:h-24 mr-2">
                <img class="w-14 h-14 lg:w-18 lg:h-18" src="/public/assets/svg/icon.svg">
                <p class="md:hidden lg:flex text-xl font-bold text-white">AnterKuy</p>
            </a>

            <div class="hidden md:flex flex-col gap-2">
                <div class="flex flex-col gap-4">
                    <p class="hidden lg:flex uppercase text-white">menu</p>
                    <div class="flex flex-col w-full gap-2">
                        <a href="/dashboard" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4" :class="page === 'dashboard' && 'bg-[#b85e20]' ">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-house text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Beranda</p>
                        </a>
                        <a href="/dashboard/lacak" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-truck text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Lacak</p>
                        </a>
                        <a href="/dashboard/pesan" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-cart-shopping text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Pesan</p>
                        </a>
                        <a href="/dashboard/pesanan" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-3 text-white font-bold fa-solid fa-file-invoice-dollar lg:ml-1 text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Pesanan Saya</p>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <p class="hidden lg:flex uppercase text-white">umum</p>
                    <div class="flex flex-col w-full gap-2">
                        <a href="/logout" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-right-from-bracket lg:ml-1 text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Log Out</p>
                        </a>
                    </div>
                </div>

                <!-- TODO: Only show if user has admin role -->
                <div class="flex flex-col gap-4">
                    <p class="hidden lg:flex uppercase text-white">admin</p>
                    <div class="flex flex-col w-full gap-2">
                        <a href="/admin/pesanan" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-3 text-white font-bold fa-solid fa-file-invoice-dollar lg:ml-1 text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">List Pesanan</p>
                        </a>

                        <a href="/admin/pengguna" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-3 text-white font-bold fa-solid fa-user lg:ml-1 text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">List Pengguna</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-10 w-full h-auto flex flex-col md:flex-row mt-4 md:mt-0 gap-10 mb-6 md:mb-0">
            <div class="w-full h-auto md:h-full flex flex-col md:gap-6">
                <p class="font-bold text-3xl">Selamat siang, Wibu !</p>
                <div class="flex flex-col gap-10 mt-2 md:mt-0">
                    <a href="/dashboard/lacak/YlvejVyADlKMhTAnRNGw6" class="flex flex-col w-full h-32 bg-[#eeeeee] rounded-2xl shadow-xl hover:shadow-2xl">
                        <div class="flex items-center h-8 w-full border-b border-[#83838350] px-4 py-5 mt-1">
                            <p class="text-[#838383]">
                                Status Pengiriman Terakhir
                            </p>
                        </div>

                        <div class="flex flex-col px-4 mt-2">
                            <p class="text-[#838383] font-bold">
                                Iphone 15 Pro Max (1Kg)
                            </p>
                            <div class="flex flex-row justify-between">
                                <div class="mt-1 text-left">
                                    <p class="text-xs text-[#838383] ">
                                        Sedang ada di Rengasdengklok
                                    </p>
                                    <p class="text-xs text-[#838383] ">
                                        Jawa Timur
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-[#838383] ">
                                        16 Des
                                    </p>
                                    <p class="text-xs text-[#838383] ">
                                        16:20
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div class="grid grid-cols-2 w-full h-80 bg-[#eeeeee] rounded-2xl shadow-xl hover:shadow-2xl p-4 justify-center">
                        <div class="flex flex-row justify-center items-center p-4 gap-4 border-b border-r border-[#83838350]">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 2.svg">
                            <div class="flex flex-col">
                                <p class="text-[#22092c] font-bold text-lg">30+</p>
                                <p class="text-[#838383] text-xs lg:text-base">Sedang Dikirim</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center p-4 gap-4 border-b border-[#83838350]">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 15.svg">
                            <div class="flex flex-col">
                                <p class="text-[#22092c] font-bold text-lg">5+</p>
                                <p class="text-[#838383] text-xs lg:text-base">Sedang Ditahan</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center p-4 gap-4 border-r border-[#83838350]">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 16.svg">
                            <div class="flex flex-col">
                                <p class="text-[#22092c] font-bold text-lg">5+</p>
                                <p class="text-[#838383] text-xs lg:text-base">Sedang Ditahan</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center p-4 gap-4">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 4.svg">
                            <div class="flex flex-col">
                                <p class="text-[#22092c] font-bold text-lg">5+</p>
                                <p class="text-[#838383] text-xs lg:text-base">Sedang Ditahan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex w-full h-[34rem] md:pt-[3.75rem]">
                <div class="w-full h-full bg-[#eeeeee] rounded-2xl shadow-xl hover:shadow-2xl">
                    <a href="/dashboard/lacak" class="flex flex-col h-1/2 w-full justify-center items-center gap-2 border-b border-[#83838350] p-8">
                        <img class="w-32 h-32" src="/public/assets/images/dashboard/Asset 8.svg">
                        <div class="flex flex-col w-full items-center justify-center">
                            <p class="text-xl text-[#838383] font-bold ">
                                Cek Resi
                            </p>
                            <p class="text-lg text-[#838383]">
                                Masukan nomor resi anda disini
                            </p>
                        </div>
                    </a>
                    <a href="/dashboard/cek_tarif" class="flex flex-col h-1/2 w-full justify-center items-center gap-2">
                        <img class="w-44 h-32" src="/public/assets/images/dashboard/Asset 9.svg">
                        <div class="flex flex-col w-full items-center justify-center">
                            <p class="text-xl text-[#838383] font-bold ">
                                Cek Tarif
                            </p>
                            <p class="text-lg text-[#838383]">
                                Cek tarif AnterKuy
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="sticky inset-x-0 bottom-0 z-10 md:hidden w-full mt-auto px-4">
        <div class="flex w-full h-[4.5rem] justify-between bg-[#FF9130] px-4 gap-6 py-1 rounded-full mb-2">
            <div class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]" :class="page === 'dashboard' && 'bg-[#b85e20]'">
                <i class="text-white font-bold fa-solid fa-house text-2xl"></i>
            </div>

            <div class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                <i class="text-white font-bold fa-solid fa-truck text-2xl"></i>
            </div>

            <div class="flex w-12 h-12 relative justify-center">
                <div class="flex absolute w-20 h-20 bg-[#FCFCFC] rounded-full -top-10 justify-center">
                    <div class="flex w-16 h-16 bg-[#FF9130] hover:bg-[#b85e20] rounded-full mt-2 justify-center items-center">
                        <i class="text-white font-bold fa-solid fa-cart-shopping text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                <i class="text-white font-bold fa-solid fa-file-invoice-dollar text-2xl"></i>
            </div>

            <div class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                <i class="text-white font-bold fa-solid fa-right-from-bracket text-2xl"></i>
            </div>
        </div>
    </footer>


</body>

</html>