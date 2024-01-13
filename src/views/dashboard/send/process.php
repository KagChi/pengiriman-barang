<?php
include "./src/components/head.php";
?>

<title>Halaman Dashboard</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col dark:bg-[#121212]">
    <div class="flex flex-col md:flex-row h-auto">
        <div class="flex flex-col w-full bg-[#FF9130] dark:bg-[#EE7214] md:w-28 lg:w-[20%] md:h-full py-4 px-6 gap-4">
            <a href="/" class="flex flex-row justify-center items-center h-12 md:h-24 mr-2">
                <img class="w-14 h-14 lg:w-18 lg:h-18" src="/public/assets/svg/icon.svg">
                <p class="md:hidden lg:flex text-xl font-bold text-white">AnterKuy</p>
            </a>

            <div class="hidden md:flex flex-col gap-2">
                <div class="flex flex-col gap-4">
                    <p class="hidden lg:flex uppercase text-white">menu</p>
                    <div class="flex flex-col w-full gap-2">
                        <a href="/dashboard" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4"">
                            <i class=" lg:w-4 text-white font-bold fa-solid fa-house text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Beranda</p>
                        </a>
                        <a href="/dashboard/lacak" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-truck text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Lacak</p>
                        </a>
                        <a href="/dashboard/kirim" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-paper-plane text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Kirim</p>
                        </a>
                        <a href="/dashboard/kiriman" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-3 text-white font-bold fa-solid fa-file-invoice-dollar lg:ml-1 text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Kiriman Saya</p>
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

                <?php if ($role == 1 || $role == 2) { ?>
                    <div class="flex flex-col gap-4">
                        <p class="hidden lg:flex uppercase text-white">admin</p>
                        <div class="flex flex-col w-full gap-2">
                            <a href="/admin/kiriman" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                                <i class="lg:w-3 text-white font-bold fa-solid fa-file-invoice-dollar lg:ml-1 text-lg"></i>
                                <p class="hidden lg:flex text-white font-bold text-lg">List Kiriman</p>
                            </a>

                            <?php if ($role == 1) { ?>
                                <a href="/admin/pengguna" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                                    <i class="lg:w-3 text-white font-bold fa-solid fa-user lg:ml-1 text-lg"></i>
                                    <p class="hidden lg:flex text-white font-bold text-lg">List Pengguna</p>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="w-full h-screen flex flex-col mt-4 md:mt-0 gap-10 mb-6 md:mb-0">
            <div class="flex flex-col">
                <div class="flex flex-col p-6 md:p-10">
                    <p class="text-2xl font-extrabold dark:text-white">Pembayaran</p>
                    <p class="md:text-lg font-extrabold dark:text-white">(Pembayaran hanya bisa menggunakan Tunai)</p>
                </div>
                <div class="border-b border-4 border-[#FF9130] dark:border-white" />
            </div>

            <div data-aos="fade-up" class="p-6 md:p-10 flex flex-col gap-y-4 md:gap-y-0 justify-between md:mt-2 gap-x-10">
                <div class="flex flex-col lg:flex-row gap-10 lg:gap-0">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col">
                            <p class="dark:text-white">Nomor Resi:</p>
                            <div class="flex justify-center items-center w-40 md:w-auto border border-2 border-[#FF9130] dark:border-white p-1">
                                <p class="text-xl md:text-6xl dark:text-white"><?= htmlspecialchars($resi) ?></p>
                            </div>
                        </div>
                        <p class="dark:text-white text-xl">Silahkan kirim barang ke kantor <span class="font-extrabold dark:text-white">AnterKuy</span> terdekat</p>
                    </div>
                    <div class="flex flex-col w-full lg:ml-auto lg:w-64 bg-[#eeeeee] rounded-md shadow-2xl">
                        <div class="flex flex-row gap-4 items-center justify-center bg-[#FF9130] p-2 rounded-t-md">
                            <i class="text-white fa-solid fa-wallet"></i>
                            <p class="text-white font-bold">Detail Pembayaran</p>
                        </div>
                        <div class="flex flex-col h-full py-2">
                            <div class="flex flex-col bg-[#eeeeee]">
                                <div class="flex justify-between px-4">
                                    <p>AnterKuy Fast</p>
                                    <p>Rp <?= htmlspecialchars(number_format($price)) ?></p>
                                </div>
                            </div>
                            <div class="flex justify-between px-4 rounded-b-md mt-auto">
                                <p class="font-bold">Total</p>
                                <p class="font-bold">Rp <?= htmlspecialchars(number_format($price)) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="/dashboard/kirim" class="flex justify-center items-center w-full bg-[#ef5941] p-2 rounded-lg mt-32 transition delay-150 duration-300 hover:scale-105 ease-in-out">
                    <p class="text-white font-bold text-xl">OK KUY !</p>
                </a>
            </div>
        </div>

        <div class="relative">
            <a onclick="changeTheme()" id="darkModeToggler" class="cursor-pointer flex justify-center items-center h-14 w-14 bg-[#EE7214] dark:bg-[#22092C] rounded-full text-white p-2 fixed top-0 right-0 mt-3 mr-4">
                <i id="darkModeTogglerIcon" class="fa-solid fa-moon fa-xl"></i>
            </a>
        </div>

        <footer class="sticky inset-x-0 bottom-0 z-10 md:hidden w-full mt-auto px-4">
            <div class="flex w-full h-[4.5rem] justify-between bg-[#FF9130] dark:bg-[#EE7214] px-4 gap-6 py-1 rounded-full mb-2">
                <a href="/dashboard" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                    <i class="text-white font-bold fa-solid fa-house text-2xl"></i>
                </a>

                <a href="/dashboard/lacak" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                    <i class="text-white font-bold fa-solid fa-truck text-2xl"></i>
                </a>

                <div class="flex w-12 h-12 relative justify-center">
                    <div class="flex absolute w-20 h-20 bg-[#FCFCFC] rounded-full -top-10 justify-center">
                        <a href="/dashboard/kirim" class="flex w-16 h-16 bg-[#FF9130] dark:bg-[#EE7214] hover:bg-[#b85e20] bg-[#b85e20] rounded-full mt-2 justify-center items-center">
                            <i class="text-white font-bold fa-solid fa-cart-shopping text-3xl"></i>
                        </a>
                    </div>
                </div>

                <a href="/dashboard/kiriman" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                    <i class="text-white font-bold fa-solid fa-file-invoice-dollar text-2xl"></i>
                </a>

                <a href="/logout" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                    <i class="text-white font-bold fa-solid fa-right-from-bracket text-2xl"></i>
                </a>
            </div>
        </footer>
</body>
</html>