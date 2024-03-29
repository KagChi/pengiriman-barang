<?php
include "./src/components/head.php";
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const element = document.getElementById("register");
        element.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            fetch("/api/account/create", {
                method: "POST",
                body: formData,
                credentials: "same-origin"
            }).then(async x => {
                try {
                    const response = await x.json();
                    iziToast.show({
                        title: `<div class="flex justify-center items-center w-4 h-4 mr-4"><i class="fa-solid ${x.ok ? "fa-check" : "fa-x"} fa-2xl"></i></div>`,
                        message: response.message,
                        position: 'topRight',
                        color: "#EE7214",
                        titleColor: "#FCFCFC",
                        messageColor: "#FCFCFC"
                    });

                    if (x.ok) {
                        setTimeout(() => window.location.search = window.location.search.replace("?ref=register", "?ref=login"), 2000);
                    }

                } catch {
                    iziToast.show({
                        title: '<div class="flex justify-center items-center w-4 h-4 mr-4"><i class="fa-solid fa-x fa-2xl"></i></div>',
                        message: "Sebuah kesalahan, mohon refresh browser anda.",
                        position: 'topRight',
                        color: "#EE7214",
                        titleColor: "#FCFCFC",
                        messageColor: "#FCFCFC"
                    });
                }
            })
        })
    })
</script>

<title>Halaman Akun</title>

<!DOCTYPE html>
<html lang="en">

<body class="min-h-screen flex flex-col dark:bg-[#121212]">
    <section class="flex flex-col lg:flex-row w-full h-screen">
        <div class="flex flex-col bg-[#FF9130] dark:bg-[#EE7214] w-full h-64 md:h-80 lg:w-2/5 lg:h-screen md:p-4 justify-center md:justify-start">
            <a href="/" class="hidden lg:flex w-4 h-4 border-white border-4 justify-center items-center rounded-full p-4">
                <i class="text-white fa-solid fa-arrow-left text-xl"></i>
            </a>
            <div class="flex flex-col justify-center items-center lg:h-screen lg:mb-28">
                <img class="w-20 h-20 md:w-48 md:h-48" src="/public/assets/svg/icon.svg">
                <p class="text-4xl md:text-5xl font-bold text-white">AnterKuy</p>
            </div>
        </div>

        <form id="register" action="POST" class="form flex flex-col p-8 w-full h-auto md:h-screen justify-center items-center gap-4 md:mt-12 lg:mt-0" x-data="{ next: false }" autocomplete="do-not-autofill">
            <p class="font-extrabold text-4xl dark:text-[#FCFCFC]">Buat Akun</p>
            <input hidden value="<?= $csrf ?>" name="csrf_token">

            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-show="!next" class="grid grid-cols-1 gap-2 w-full md:px-20 lg:px-48">
                <div class="grid grid-cols-1">
                    <p class="dark:text-[#FCFCFC]">Nama Depan<span class="text-[#FF0000]">*</span></p>
                    <input class="bg-[#22092c20] dark:bg-[#FCFCFC20] text-[#22092c] dark:text-[#FCFCFC] focus:outline-none rounded-md p-1 h-10 px-4" name="first_name" type="first_name" autocomplete="off" required>
                </div>

                <div class="grid grid-cols-1">
                    <p class="dark:text-[#FCFCFC]">Nama Belakang<span class="text-[#FF0000]">*</span></p>
                    <input class="bg-[#22092c20] dark:bg-[#FCFCFC20] text-[#22092c] dark:text-[#FCFCFC] focus:outline-none rounded-md p-1 h-10 px-4" name="last_name" type="last_name" autocomplete="off" required>
                </div>

                <div class="grid grid-cols-1">
                    <p class="dark:text-[#FCFCFC]">Email<span class="text-[#FF0000]">*</span></p>
                    <input class="bg-[#22092c20] dark:bg-[#FCFCFC20] text-[#22092c] dark:text-[#FCFCFC] focus:outline-none rounded-md p-1 h-10 px-4" name="email" type="email" autocomplete="off" required>
                </div>

                <div class="grid grid-cols-1">
                    <p class="dark:text-[#FCFCFC]">Nomor Telepon<span class="text-[#FF0000]">*</span></p>
                    <input class="bg-[#22092c20] dark:bg-[#FCFCFC20] text-[#22092c] dark:text-[#FCFCFC] focus:outline-none rounded-md p-1 h-10 px-4" name="phone" type="number" autocomplete="off" required>
                </div>

                <div class="flex flex-row gap-2 mt-2">
                    <a class="text-xs dark:text-[#FCFCFC]">
                        Sudah mempunyai akun?
                    </a>
                    <a href="/login" class="text-xs underline dark:text-[#FCFCFC]">
                        Login sekarang
                    </a>
                </div>

                <div class="flex flex-row justify-between lg:justify-end mt-4">
                    <a href="/" class="flex lg:hidden flex justify-center items-center h-10 w-20 rounded-md bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130]">
                        <i class="text-white fa-solid fa-arrow-left fa-xl"></i>
                    </a>
                    <a type="button" @click="next = ! next" class="cursor-pointer flex justify-center items-center w-20 h-10 rounded-md bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130]" style="box-shadow: 0 8px 10px 4px rgb(0 0 0 / 0.1);">
                        <i class="text-white fa-solid fa-arrow-right fa-xl"></i>
                    </a>
                </div>
            </div>

            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-show="next" class="grid grid-cols-1 gap-2 w-full md:px-20 lg:px-48">
                <div class="grid grid-cols-1">
                    <p class="dark:text-[#FCFCFC]">Username<span class="text-[#FF0000]">*</span></p>
                    <input class="bg-[#22092c20] dark:bg-[#FCFCFC20] text-[#22092c] dark:text-[#FCFCFC] focus:outline-none rounded-md p-1 h-10 px-4" name="username" type="username" autocomplete="off" required>
                </div>

                <div class="grid grid-cols-1">
                    <p class="dark:text-[#FCFCFC]">Password<span class="text-[#FF0000]">*</span></p>
                    <div class="flex flex-row bg-[#22092c20] dark:bg-[#FCFCFC20] text-[#22092c] dark:text-[#FCFCFC] rounded-md p-1 h-10 justify-center items-center gap-2 px-4">
                        <input id="password" class="bg-transparent w-full focus:outline-none" name="password" type="password" autocomplete="off" required>
                        <i id="password-icon" onclick="revealPassword('password')" class="cursor-pointer text-[#22092C] dark:text-[#FCFCFC] fa-solid fa-eye"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1">
                    <p class="dark:text-[#FCFCFC]">Konfirmasi Password<span class="text-[#FF0000]">*</span></p>
                    <div class="flex flex-row bg-[#22092c20] dark:bg-[#FCFCFC20] text-[#22092c] dark:text-[#FCFCFC] rounded-md p-1 h-10 justify-center items-center gap-2 px-4">
                        <input id="konfirmasi-password" class="bg-transparent w-full focus:outline-none" name="konfirmasi_password" type="password" autocomplete="off" required>
                        <i id="konfirmasi-password-icon" onclick="revealPassword('konfirmasi-password')" class="cursor-pointer text-[#22092C] dark:text-[#FCFCFC] fa-solid fa-eye"></i>
                    </div>
                </div>

                <div class="flex flex-row justify-between mt-4">
                    <a @click="next = ! next" class="cursor-pointer flex justify-center items-center h-10 w-20 rounded-md bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130]" style="box-shadow: 0 8px 10px 4px rgb(0 0 0 / 0.1);">
                        <i class="text-white fa-solid fa-arrow-left fa-xl"></i>
                    </a>
                    <button type="submit" class="flex justify-center items-center w-20 h-10 rounded-md bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130]" style="box-shadow: 0 8px 10px 4px rgb(0 0 0 / 0.1);">
                        <i class="text-white fa-solid fa-arrow-right fa-xl"></i>
                    </button>
                </div>
            </div>
        </form>
    </section>

    <div class="relative">
        <a onclick="changeTheme()" id="darkModeToggler" class="cursor-pointer flex justify-center items-center h-14 w-14 bg-[#22092C] rounded-full text-white p-2 fixed bottom-0 right-0 mb-6 mr-4">
            <i id="darkModeTogglerIcon" class="fa-solid fa-moon fa-xl"></i>
        </a>
    </div>
</body>