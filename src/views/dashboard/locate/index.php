<?php
include "./src/components/head.php";
?>

<title>Halaman Dashboard</title>

<style>
    body {
        background-image: url("/public/assets/images/background.png");
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col dark:bg-[#121212] h-auto">
    <div class="flex flex-col md:flex-row h-full">
        <div class="flex flex-col w-full bg-[#FF9130] dark:bg-[#EE7214] md:w-28 lg:w-[20%] md:h-full py-4 px-6 gap-4">
            <a href="/" class="flex flex-row justify-center items-center h-12 md:h-24 mr-2">
                <img class="w-14 h-14 lg:w-18 lg:h-18" src="/public/assets/svg/icon.svg">
                <p class="md:hidden lg:flex text-xl font-bold text-white">AnterKuy</p>
            </a>

            <div class="hidden md:flex flex-col gap-2">
                <div class="flex flex-col gap-4">
                    <p class="hidden lg:flex uppercase text-white">menu</p>
                    <div class="flex flex-col w-full gap-2">
                        <a href="/dashboard" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-house text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Beranda</p>
                        </a>
                        <a href="/dashboard/lacak" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-truck text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Lacak</p>
                        </a>
                        <a href="/dashboard/kirim" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-paper-plane text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Kirim</p>
                        </a>
                        <?php if ($sessionActive == 'true') { ?>
                            <a href="/dashboard/kiriman" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                                <i class="lg:w-3 text-white font-bold fa-solid fa-file-invoice-dollar lg:ml-1 text-lg"></i>
                                <p class="hidden lg:flex text-white font-bold text-lg">Kiriman Saya</p>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($sessionActive == 'true') { ?>
                    <div class="flex flex-col gap-4">
                        <p class="hidden lg:flex uppercase text-white">umum</p>
                        <div class="flex flex-col w-full gap-2">
                            <a href="/logout" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                                <i class="lg:w-4 text-white font-bold fa-solid fa-right-from-bracket lg:ml-1 text-lg"></i>
                                <p class="hidden lg:flex text-white font-bold text-lg">Log Out</p>
                            </a>
                        </div>
                    </div>
                <?php } ?>

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

        <div class="flex flex-col p-6 md:p-10 w-full h-full mt-4 md:mt-0 gap-10 mb-6 md:mb-0">
            <div class="flex flex-col rounded-2xl w-full h-48 bg-[#EEEEEE] p-4 px-6 md:px-8">
                <div>
                    <p class="text-2xl font-bold">Lacak Pengiriman</p>
                    <p class="font-bold text-sm">Masukan Nomor Pengiriman</p>
                </div>
                <form class="flex flex-row mt-auto mb-6 gap-4" method="post" action="/dashboard/lacak">
                    <input name="resi" class="w-full h-12 rounded-xl px-4" placeholder="Masukan nomor resi ">
                    <button type="submit" class="flex w-32 bg-[#FF9130] rounded-xl justify-center items-center text-white font-bold text-xl">
                        Lacak
                    </button>
                </form>
            </div>

            <img class="transition delay-150 duration-300 hover:scale-110 ease-in-out mt-16 ml-auto mr-auto h-64 w-80 md:w-[26rem] md:h-72" src="/public/assets/images/locate.png">
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

            <a href="/dashboard/lacak" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20] bg-[#b85e20]">
                <i class="text-white font-bold fa-solid fa-truck text-2xl"></i>
            </a>

            <div class="flex w-12 h-12 relative justify-center">
                <div class="flex absolute w-20 h-20 bg-[#FCFCFC] rounded-full -top-10 justify-center">
                    <a href="/dashboard/kirim" class="flex w-16 h-16 bg-[#FF9130] dark:bg-[#EE7214] hover:bg-[#b85e20] rounded-full mt-2 justify-center items-center">
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