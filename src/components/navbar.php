<nav class="w-full h-24 p-1 px-6 md:px-12 pt-4 md:pt-8 justify-between flex flex-row fixed bg-[#FCFCFC] shadow-2xl" x-data="{ page: '<?= $page; ?>', ref: '<?= $ref; ?>' }">
    <a href="./" class="flex flex-row items-center gap-2 h-full">
        <img class="w-8 h-8 md:w-10 md:h-10 bg-[#FF9130] rounded-md" src="./public/assets/svg/icon.svg">

        <div class="text-[#22092C] font-bold text-lg md:text-2xl flex flex-row">
            <p>Anter</p>
            <p class="text-[#FF9130]">Kuy</p>
        </div>
    </a>

    <div class="hidden md:flex flex-row gap-8 h-full justify-end items-center">
        <div class="pt-2 flex gap-8 flex-row">
            <a href="./" class="flex flex-col items-center">
                <p :class="page === 'home' ? 'text-[#22092C] font-bold' : '' ">Beranda</p>
                <div :class="page === 'home' ? 'w-8 border-b-4 border-[#FF9130]' : '' "></div>
            </a>
            <a class="flex flex-col items-center">
                <p class="hover:text-[#FF9130] text-[#22092C]">Layanan</p>
            </a>
            <a class="flex flex-col items-center">
                <p class="hover:text-[#FF9130] text-[#22092C]">Lacak</p>
            </a>
            <!-- TODO: Remove when user logged-in -->
            <a href="./account?ref=register" :class="page === 'account' ? 'flex flex-col font-bold text-[#EE7214] items-center' : 'flex flex-col font-bold hover:text-[#EE7214] text-[#FF9130] items-center' ">
                Daftar
                <div :class="ref === 'register' ? 'w-8 border-b-4 border-[#FF9130]' : '' "></div>
            </a>
        </div>

        <!-- TODO: Remove when user logged-in -->
        <a href="./account?ref=login" class="flex flex-row gap-2 text-white font-bold rounded-md h-10 w-24 items-center justify-center hover:bg-[#EE7214] bg-[#FF9130]">
            <i class="text-white fa-solid fa-right-to-bracket"></i>
            <p>Masuk</p>
        </a>
    </div>

    <div class="flex md:hidden flex-col w-32 gap-4 mt-3" x-data="{ open: false }">
        <a x-on:click="open = ! open" class="h-10 w-10 items-center ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 256 256" fill="none" id="navbar">
                <defs>
                    <linearGradient id="gradient1">
                        <stop class="stop1" offset="0%" stop-color="#8f66ff"></stop>
                        <stop class="stop2" offset="100%" stop-color="#3d12ff"></stop>
                    </linearGradient>
                </defs>
                <rect id="backgr" width="256" height="256" fill="none" rx="60"></rect>
                <g id="group" transform="translate(0,0) scale(1)">
                    <path d="M64.000 74.667H192.000M64.000 181.333H192.000" stroke="#22092c" stroke-width="14" stroke-linecap="round" stroke-linejoin="round" id="primary"></path>
                    <path d="M64.000 128.000H192.000" stroke="#22092c" stroke-width="14" stroke-linecap="round" stroke-linejoin="round" id="secondary"></path>
                </g>
            </svg>
        </a>

        <div class="flex flex-col gap-2 bg-[#FFD28F] rounded-md p-2" x-show="open">
            <a href="./" class="flex hover:bg-[#EE7214] bg-[#FF9130] w-full h-8 rounded-sm items-center justify-between gap-2 px-2">
                <i class="text-white fa-solid fa-house"></i>
                <p class="text-white font-bold text-lg">Beranda</p>
            </a>

            <a class="flex hover:bg-[#EE7214] bg-[#FF9130] w-full h-8 rounded-sm items-center justify-between gap-2 px-2">
                <i class="text-white fa-solid fa-box"></i>
                <p class="text-white font-bold text-lg">Layanan</p>
            </a>

            <a class="flex hover:bg-[#EE7214] bg-[#FF9130] w-full h-8 rounded-sm items-center justify-between gap-2 px-2">
                <i class="text-white fa-solid fa-location-dot"></i>
                <p class="text-white font-bold text-lg">Lacak</p>
            </a>

            <!-- TODO: Remove if user has logged-in -->

            <a href="./account?ref=register" class="flex hover:bg-[#EE7214] bg-[#FF9130] w-full h-8 rounded-sm items-center justify-between gap-2 px-2">
                <i class="text-white fa-solid fa-user-plus"></i>
                <p class="text-white font-bold text-lg">Daftar</p>
            </a>

            <a href="./account?ref=login" class="flex hover:bg-[#EE7214] bg-[#FF9130] w-full h-8 rounded-sm items-center justify-between gap-2 px-2">
                <i class="text-white fa-solid fa-right-to-bracket"></i>
                <p class="text-white font-bold text-lg">Masuk</p>
            </a>
        </div>
    </div>
</nav>