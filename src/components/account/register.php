<section class="flex flex-col lg:flex-row w-full h-screen">
    <div class="flex flex-col bg-[#FF9130] w-full h-64 md:h-80 lg:w-2/5 lg:h-screen md:p-4 justify-center md:justify-start">
        <a href="./" class="hidden lg:flex w-4 h-4 border-white border-4 justify-center items-center rounded-full p-4">
            <i class="text-white fa-solid fa-arrow-left text-xl"></i>
        </a>
        <div class="flex flex-col justify-center items-center lg:h-screen">
            <img class="w-20 h-20 md:w-48 md:h-48" src="./public/assets/svg/icon.svg">
            <p class="text-4xl md:text-5xl font-bold text-white">AnterKuy</p>
        </div>
    </div>

    <form class="flex flex-col p-8 w-full h-auto md:h-screen justify-center items-center gap-4 mt-12 md:mt-0" x-data="{ next: false }" autocomplete="do-not-autofill">
        <p class="font-extrabold	 text-4xl">Buat Akun</p>

        <div x-show="!next" class="grid grid-cols-1 gap-2 w-full md:px-20 lg:px-48">
            <div class="grid grid-cols-1">
                <p>Nama Depan<span class="text-[#FF0000]">*</span></p>
                <input class="bg-[#22092c20] text-[#22092c] focus:outline-none rounded-md p-1 h-10 px-4" name="first_name" type="first_name" autocomplete="off" required>
            </div>

            <div class="grid grid-cols-1">
                <p>Nama Belakang<span class="text-[#FF0000]">*</span></p>
                <input class="bg-[#22092c20] text-[#22092c] focus:outline-none rounded-md p-1 h-10 px-4" name="last_name" type="last_name" autocomplete="off" required>
            </div>

            <div class="grid grid-cols-1">
                <p>Email<span class="text-[#FF0000]">*</span></p>
                <input class="bg-[#22092c20] text-[#22092c] focus:outline-none rounded-md p-1 h-10 px-4" name="email" type="email" autocomplete="off" required>
            </div>

            <div class="grid grid-cols-1">
                <p>Nomor Telepon<span class="text-[#FF0000]">*</span></p>
                <input class="bg-[#22092c20] text-[#22092c] focus:outline-none rounded-md p-1 h-10 px-4" name="phone" type="phone" autocomplete="off" required>
            </div>

            <div class="flex flex-row gap-2 mt-2">
                <a class="text-xs">
                    Sudah mempunyai akun?
                </a>
                <a href="./account?ref=login" class="text-xs underline">
                    login sekarang
                </a>
            </div>

            <div class="flex flex-row justify-between lg:justify-end mt-4">
                <a href="./" class="flex lg:hidden flex justify-center items-center h-10 w-20 rounded-md bg-[#FF9130]">
                    <i class="text-white fa-solid fa-arrow-left fa-xl"></i>
                </a>
                <button @click="next = ! next" class="flex justify-center items-center w-20 h-10 rounded-md bg-[#FF9130]" style="box-shadow: 0 8px 10px 4px rgb(0 0 0 / 0.1);">
                    <i class="text-white fa-solid fa-arrow-right fa-xl"></i>
                </button>
            </div>
        </div>

        <div x-show="next" class="grid grid-cols-1 gap-2 w-full md:px-20 lg:px-48">
            <div class="grid grid-cols-1">
                <p>Username<span class="text-[#FF0000]">*</span></p>
                <input class="bg-[#22092c20] text-[#22092c] focus:outline-none rounded-md p-1 h-10 px-4" name="username" type="username" autocomplete="off" required>
            </div>

            <div class="grid grid-cols-1">
                <p>Password<span class="text-[#FF0000]">*</span></p>
                <div class="flex flex-row bg-[#22092c20] text-[#22092c] rounded-md p-1 h-10 justify-center items-center gap-2 px-4">
                    <input class="bg-transparent w-full focus:outline-none" name="password" type="password" autocomplete="off" required>
                    <i class="text-[#22092C] fa-solid fa-eye"></i>
                </div>
            </div>

            <div class="grid grid-cols-1">
                <p>Konfirmasi Password<span class="text-[#FF0000]">*</span></p>
                <div class="flex flex-row bg-[#22092c20] text-[#22092c] rounded-md p-1 h-10 justify-center items-center gap-2 px-4">
                    <input class="bg-transparent w-full focus:outline-none" name="konfirmasi_password" type="password" autocomplete="off" required>
                    <i class="text-[#22092C] fa-solid fa-eye"></i>
                </div>
            </div>

            <div class="flex flex-row justify-between mt-4">
                <a @click="next = ! next" class="flex justify-center items-center h-10 w-20 rounded-md bg-[#FF9130]" style="box-shadow: 0 8px 10px 4px rgb(0 0 0 / 0.1);">
                    <i class="text-white fa-solid fa-arrow-left fa-xl"></i>
                </a>
                <button type="submit" class="flex justify-center items-center w-20 h-10 rounded-md bg-[#FF9130]" style="box-shadow: 0 8px 10px 4px rgb(0 0 0 / 0.1);">
                    <i class="text-white fa-solid fa-arrow-right fa-xl"></i>
                </button>
            </div>
        </div>
    </form>
</section>