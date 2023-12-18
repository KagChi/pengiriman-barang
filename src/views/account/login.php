<?php
include "./src/components/head.php";
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const element = document.getElementById("login");
        element.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            fetch("/api/account/login", {
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
                        setTimeout(() => {
                            window.location.replace("/dashboard")
                        }, 2000);
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

<body class="min-h-screen flex flex-col">
    <section class="flex flex-col lg:flex-row w-full h-screen">
        <div class="flex flex-col bg-[#FF9130] w-full h-64 md:h-80 lg:w-2/5 lg:h-screen md:p-4 justify-center md:justify-start">
            <a href="/" class="hidden lg:flex w-4 h-4 border-white border-4 justify-center items-center rounded-full p-4">
                <i class="text-white fa-solid fa-arrow-left text-xl"></i>
            </a>
            <div class="flex flex-col justify-center items-center lg:h-screen">
                <img class="w-20 h-20 md:w-48 md:h-48" src="/public/assets/svg/icon.svg">
                <p class="text-4xl md:text-5xl font-bold text-white">AnterKuy</p>
            </div>
        </div>

        <form id="login" class="flex flex-col p-8 w-full h-auto md:h-screen justify-center items-center gap-4 md:mt-12 lg:mt-0" autocomplete="do-not-autofill">
            <p class="font-extrabold text-4xl">Login Akun</p>
            <input hidden value="<?= $csrf ?>" name="csrf_token">
            <div class="grid grid-cols-1 gap-2 w-full md:px-20 lg:px-44">
                <div class="grid grid-cols-1">
                    <p>Email<span class="text-[#FF0000]">*</span></p>
                    <input class="bg-[#22092c20] text-[#22092c] focus:outline-none rounded-md p-1 h-10 px-4" name="email" type="text" autocomplete="off" required>
                </div>

                <div class="grid grid-cols-1">
                    <p>Password<span class="text-[#FF0000]">*</span></p>
                    <div class="flex flex-row bg-[#22092c20] text-[#22092c] rounded-md p-1 h-10 justify-center items-center gap-2 px-4">
                        <input id="password" class="bg-transparent w-full focus:outline-none" name="password" type="password" autocomplete="off" required>
                        <i id="password-icon" onclick="revealPassword('password')" class="text-[#22092C] fa-solid fa-eye"></i>
                    </div>
                </div>

                <div class="flex flex-row justify-between">
                    <div class="flex flex-col md:flex-row gap-2 mt-2">
                        <a class="text-xs">
                            Belum mempunyai akun?
                        </a>
                        <a href="/account?ref=register" class="text-xs underline">
                            Daftar sekarang
                        </a>
                    </div>
                    <div class="flex flex-col md:flex-row  gap-2 mt-2">
                        <a href="/account?ref=reset" class="text-xs underline">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <div class="flex flex-row justify-between lg:justify-end mt-4">
                    <a href="/" class="flex lg:hidden flex justify-center items-center h-10 w-20 rounded-md bg-[#FF9130]">
                        <i class="text-white fa-solid fa-arrow-left fa-xl"></i>
                    </a>
                    <button type="submit" class="flex justify-center items-center w-20 h-10 rounded-md bg-[#FF9130]" style="box-shadow: 0 8px 10px 4px rgb(0 0 0 / 0.1);">
                        <i class="text-white fa-solid fa-arrow-right fa-xl"></i>
                    </button>
                </div>
            </div>
        </form>
    </section>
</body>