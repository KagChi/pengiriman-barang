<section class="flex-1 px-6 md:px-48 lg:px-72 pt-40 flex flex-col md:flex-row mb-20 gap-4">
    <div class="w-full h-screen rounded-md">
        <form class="grid grid-cols-1 gap-4" action="./account.php" method="POST">
            <div class="grid grid-cols-1 place-items-center gap-4">
                <img class="bg-[#FF9130] rounded-md md:w-20 md:h-20 lg:w-32 lg:h-32" src="./assets/svg/icon.svg">
                <p class="font-bold uppercase text-[#22092c] lg:text-2xl">masuk ke akunmu</p>
            </div>

            <div class="grid grid-cols-1 lg:px-16 gap-4">
                <div class="grid grid-cols-1">
                    <p class="font-bold text-[#22092c]">Email Kamu</p>
                    <input class="border border border-[#22092c] bg-[#22092c40] text-[#22092c] rounded-md p-1" name="email" type="email" autocomplete="off">
                </div>

                <div class="grid grid-cols-1">
                    <p class="font-bold text-[#22092c]">Password Kamu</p>
                    <input class="border border border-[#22092c] bg-[#22092c40] text-[#22092c] rounded-md p-1" name="password" type="password" autocomplete="off">
                </div>

                <div class="flex bg-[#22092c90] w-full h-8 rounded-md justify-center items-center">
                    <p class="text-white">Lupa Password?</p>
                </div>

                <button type="submit" class="flex bg-[#22092c] w-full h-8 rounded-md justify-center items-center">
                    <p class="text-white">Masuk</p>
                </button>
            </div>
        </form>
    </div>

</section>