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
                        <a href="/dashboard" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-house text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Beranda</p>
                        </a>
                        <a href="/dashboard/lacak" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-truck text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Lacak</p>
                        </a>
                        <a href="/dashboard/kirim" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
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

        <div class="min-h-screen p-6 md:p-10 w-full h-full flex flex-col md:flex-row mt-4 md:mt-0 gap-10 mb-6 md:mb-0">
            <div class="w-full h-auto md:h-full flex flex-col md:gap-6">
                <p class="font-bold text-2xl md:text-3xl dark:text-[#FCFCFC]">Selamat <?= $time ?>, <?= $name ?> !</p>
                <div class="flex flex-col gap-10 mt-2 md:mt-0">
                    <a href="/dashboard/lacak/<?= $package["resi"] ?? "000" ?>" class="flex flex-col w-full h-32 bg-[#eeeeee] dark:bg-[#EE7214] rounded-2xl shadow-xl hover:shadow-2xl">
                        <div class="flex items-center h-8 w-full border-b border-[#83838350] dark:border-[#b85e20] px-4 py-5 mt-1">
                            <p class="text-[#838383] dark:text-[#FCFCFC]">
                                Status Pengiriman Terakhir
                            </p>
                        </div>

                        <div class="flex flex-col px-4 mt-2">
                            <p class="text-[#838383] dark:text-[#FCFCFC] font-bold">
                                <?= htmlspecialchars($package["name"] ?? "Belum Ada") ?>
                            </p>
                            <div class="flex flex-row justify-between">
                                <div class="mt-1 text-left">
                                    <p class="text-xs text-[#838383] dark:text-[#FCFCFC]">
                                        <?php
                                        $state = $package["state"] ?? "Unknown";
                                        if ($state === "on_going") {
                                            echo "Dalam Perjalanan";
                                        } else if ($state === "on_hold") {
                                            echo "Ditahan";
                                        } else if ($state === "return") {
                                            echo "Dikembalikan";
                                        } else if ($state === "done") {
                                            echo "Dikirim";
                                        } else if ($state === "done_waiting_confirmation") {
                                            echo "Menunggu Konfirmasi";
                                        } else {
                                            "Unknown";
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div class="grid grid-cols-2 w-full h-80 bg-[#eeeeee] dark:bg-[#EE7214] rounded-2xl shadow-xl hover:shadow-2xl p-4 justify-center">
                        <div class="flex flex-row justify-center items-center p-4 gap-4 border-b border-r border-[#83838350] dark:border-[#b85e20]">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 2.svg">
                            <div class="flex flex-col">
                                <p class="text-[#22092c] font-bold text-lg"><?= htmlspecialchars($onGoingCount) ?>+</p>
                                <p class="text-[#838383] dark:text-[#FCFCFC] text-xs lg:text-base">Sedang Dikirim</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center p-4 gap-4 border-b border-[#83838350] dark:border-[#b85e20]">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 15.svg">
                            <div class="flex flex-col">
                                <p class="text-[#22092c] font-bold text-lg"><?= htmlspecialchars($onHoldCount) ?>+</p>
                                <p class="text-[#838383] dark:text-[#FCFCFC] text-xs lg:text-base">Sedang Ditahan</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center p-4 gap-4 border-r border-[#83838350] dark:border-[#b85e20]">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 16.svg">
                            <div class="flex flex-col md:mr-auto">
                                <p class="text-[#22092c] font-bold text-lg"><?= htmlspecialchars($doneCount) ?>+</p>
                                <p class="text-[#838383] dark:text-[#FCFCFC] text-xs lg:text-base">Selesai</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center p-4 gap-4">
                            <img class="w-20 h-20 md:w-14 md:h-14 lg:w-20 lg:h-20" src="/public/assets/images/dashboard/Asset 4.svg">
                            <div class="flex flex-col">
                                <p class="text-[#22092c] font-bold text-lg"><?= htmlspecialchars($returnCount) ?>+</p>
                                <p class="text-[#838383] dark:text-[#FCFCFC] text-xs lg:text-base">Dikembalikan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex w-full h-96 md:pt-[3.75rem]">
                <div class="w-full h-auto bg-[#eeeeee] dark:bg-[#EE7214] rounded-2xl shadow-xl hover:shadow-2xl">
                    <a href="/dashboard/lacak" class="flex flex-col h-auto w-full justify-center items-center gap-4 py-8">
                        <div class="text-[#22092c]">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="153px" height="155px" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g>
                                    <path style="opacity:0.954" fill="currentColor" d="M 79.5,-0.5 C 87.1667,-0.5 94.8333,-0.5 102.5,-0.5C 131.965,7.2969 148.632,26.2969 152.5,56.5C 152.5,58.8333 152.5,61.1667 152.5,63.5C 147.33,98.6684 126.997,117.668 91.5,120.5C 79.5334,120.954 68.5334,117.954 58.5,111.5C 43.732,126.272 28.732,140.606 13.5,154.5C 12.8333,154.5 12.1667,154.5 11.5,154.5C 5.9877,152.988 1.9877,149.655 -0.5,144.5C -0.5,141.833 -0.5,139.167 -0.5,136.5C 13.6319,122.869 27.6319,109.035 41.5,95C 31.7706,81.3662 28.2706,66.1996 31,49.5C 36.9076,22.7605 53.0743,6.09388 79.5,-0.5 Z M 126.5,39.5 C 125.5,39.5 124.5,39.5 123.5,39.5C 122.5,39.5 121.5,39.5 120.5,39.5C 119.5,39.5 118.5,39.5 117.5,39.5C 117.5,52.8333 117.5,66.1667 117.5,79.5C 118.5,79.5 119.5,79.5 120.5,79.5C 121.5,79.5 122.5,79.5 123.5,79.5C 124.833,79.5 126.167,79.5 127.5,79.5C 115.835,98.1564 99.1685,104.99 77.5,100C 66.8768,96.2082 58.8768,89.3748 53.5,79.5C 54.3311,65.6727 54.8311,51.6727 55,37.5C 66.1168,22.134 80.9502,15.9674 99.5,19C 111.295,22.3124 120.295,29.1457 126.5,39.5 Z M 130.5,50.5 C 132.967,56.633 133.134,62.9664 131,69.5C 130.5,63.1754 130.334,56.8421 130.5,50.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.986" fill="currentColor" d="M 61.5,39.5 C 61.5,52.8333 61.5,66.1667 61.5,79.5C 60.5,79.5 59.5,79.5 58.5,79.5C 58.5,66.1667 58.5,52.8333 58.5,39.5C 59.5,39.5 60.5,39.5 61.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.353" fill="currentColor" d="M 61.5,39.5 C 62.1667,39.5 62.8333,39.5 63.5,39.5C 62.5192,52.7541 62.1858,66.0875 62.5,79.5C 62.1667,79.5 61.8333,79.5 61.5,79.5C 61.5,66.1667 61.5,52.8333 61.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 63.5,39.5 C 64.1663,45.9914 64.4996,52.6581 64.5,59.5C 64.4968,66.5351 63.8301,73.2017 62.5,79.5C 62.1858,66.0875 62.5192,52.7541 63.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.4" fill="currentColor" d="M 72.5,39.5 C 72.5,39.8333 72.5,40.1667 72.5,40.5C 72.5,53.5 72.5,66.5 72.5,79.5C 70.1667,79.5 67.8333,79.5 65.5,79.5C 65.5,66.1667 65.5,52.8333 65.5,39.5C 67.8333,39.5 70.1667,39.5 72.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 72.5,40.5 C 73.5,40.5 74.5,40.5 75.5,40.5C 75.5,53.5 75.5,66.5 75.5,79.5C 74.5,79.5 73.5,79.5 72.5,79.5C 72.5,66.5 72.5,53.5 72.5,40.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.502" fill="currentColor" d="M 72.5,40.5 C 72.5,40.1667 72.5,39.8333 72.5,39.5C 75.1667,39.5 77.8333,39.5 80.5,39.5C 80.5,52.8333 80.5,66.1667 80.5,79.5C 78.8333,79.5 77.1667,79.5 75.5,79.5C 75.5,66.5 75.5,53.5 75.5,40.5C 74.5,40.5 73.5,40.5 72.5,40.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 80.5,39.5 C 81.5,39.5 82.5,39.5 83.5,39.5C 83.5,52.8333 83.5,66.1667 83.5,79.5C 82.5,79.5 81.5,79.5 80.5,79.5C 80.5,66.1667 80.5,52.8333 80.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.429" fill="currentColor" d="M 83.5,39.5 C 84.5,39.5 85.5,39.5 86.5,39.5C 86.5,52.8333 86.5,66.1667 86.5,79.5C 85.5,79.5 84.5,79.5 83.5,79.5C 83.5,66.1667 83.5,52.8333 83.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 87.5,39.5 C 89.8333,39.5 92.1667,39.5 94.5,39.5C 94.5,52.8333 94.5,66.1667 94.5,79.5C 92.1667,79.5 89.8333,79.5 87.5,79.5C 87.5,66.1667 87.5,52.8333 87.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.004" fill="currentColor" d="M 101.5,39.5 C 101.5,52.8333 101.5,66.1667 101.5,79.5C 100.167,79.5 98.8333,79.5 97.5,79.5C 97.5,66.1667 97.5,52.8333 97.5,39.5C 98.8333,39.5 100.167,39.5 101.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.667" fill="currentColor" d="M 101.5,39.5 C 103.5,39.5 105.5,39.5 107.5,39.5C 107.5,52.8333 107.5,66.1667 107.5,79.5C 106.5,79.5 105.5,79.5 104.5,79.5C 103.833,27.5 103.167,27.5 102.5,79.5C 102.167,79.5 101.833,79.5 101.5,79.5C 101.5,66.1667 101.5,52.8333 101.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 104.5,79.5 C 103.833,79.5 103.167,79.5 102.5,79.5C 103.167,27.5 103.833,27.5 104.5,79.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.459" fill="currentColor" d="M 107.5,39.5 C 108.5,39.5 109.5,39.5 110.5,39.5C 110.5,39.8333 110.5,40.1667 110.5,40.5C 110.5,53.5 110.5,66.5 110.5,79.5C 109.5,79.5 108.5,79.5 107.5,79.5C 107.5,66.1667 107.5,52.8333 107.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 110.5,40.5 C 112.481,53.1237 113.148,66.1237 112.5,79.5C 111.833,79.5 111.167,79.5 110.5,79.5C 110.5,66.5 110.5,53.5 110.5,40.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.835" fill="currentColor" d="M 110.5,40.5 C 110.5,40.1667 110.5,39.8333 110.5,39.5C 111.5,39.5 112.5,39.5 113.5,39.5C 113.829,53.0105 113.496,66.3438 112.5,79.5C 113.148,66.1237 112.481,53.1237 110.5,40.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 120.5,39.5 C 120.5,52.8333 120.5,66.1667 120.5,79.5C 119.5,79.5 118.5,79.5 117.5,79.5C 117.5,66.1667 117.5,52.8333 117.5,39.5C 118.5,39.5 119.5,39.5 120.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.392" fill="currentColor" d="M 120.5,39.5 C 121.5,39.5 122.5,39.5 123.5,39.5C 123.5,52.8333 123.5,66.1667 123.5,79.5C 122.5,79.5 121.5,79.5 120.5,79.5C 120.5,66.1667 120.5,52.8333 120.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.357" fill="currentColor" d="M 123.5,39.5 C 124.5,39.5 125.5,39.5 126.5,39.5C 127.338,39.8417 127.672,40.5084 127.5,41.5C 127.5,53.8333 127.5,66.1667 127.5,78.5C 127.5,78.8333 127.5,79.1667 127.5,79.5C 126.167,79.5 124.833,79.5 123.5,79.5C 123.5,66.1667 123.5,52.8333 123.5,39.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:1" fill="currentColor" d="M 53.5,79.5 C 52.3263,78.4863 51.6596,77.153 51.5,75.5C 51.5,65.1667 51.5,54.8333 51.5,44.5C 51.3118,42.8967 51.8118,41.5634 53,40.5C 53.4999,53.4957 53.6666,66.4957 53.5,79.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.533" fill="currentColor" d="M 127.5,41.5 C 128.117,41.6107 128.617,41.944 129,42.5C 129.667,54.1667 129.667,65.8333 129,77.5C 128.617,78.056 128.117,78.3893 127.5,78.5C 127.5,66.1667 127.5,53.8333 127.5,41.5 Z" />
                                </g>
                                <g>
                                    <path style="opacity:0.145" fill="currentColor" d="M 51.5,44.5 C 51.5,54.8333 51.5,65.1667 51.5,75.5C 49.9481,70.5991 49.2814,65.4324 49.5,60C 49.2814,54.5676 49.9481,49.4009 51.5,44.5 Z" />
                                </g>
                            </svg>
                        </div>
                        <div class="flex flex-col w-full items-center justify-center">
                            <p class="text-xl text-[#22092c] font-bold">
                                Cek Resi
                            </p>
                            <p class="text-lg text-[#838383] dark:text-[#FCFCFC]">
                                Masukan nomor resi anda disini
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="relative">
        <a onclick="changeTheme()" id="darkModeToggler" class="cursor-pointer flex justify-center items-center h-14 w-14 bg-[#EE7214] dark:bg-[#22092C] rounded-full text-white p-2 fixed top-0 right-0 mt-3 mr-4">
            <i id="darkModeTogglerIcon" class="fa-solid fa-moon fa-xl"></i>
        </a>
    </div>

    <footer class="sticky inset-x-0 bottom-0 z-10 md:hidden w-full mt-auto px-4">
        <div class="flex w-full h-[4.5rem] justify-between bg-[#FF9130] dark:bg-[#EE7214] px-4 gap-6 py-1 rounded-full mb-2">
            <a href="/dashboard" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20] bg-[#b85e20]">
                <i class="text-white font-bold fa-solid fa-house text-2xl"></i>
            </a>

            <a href="/dashboard/lacak" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
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