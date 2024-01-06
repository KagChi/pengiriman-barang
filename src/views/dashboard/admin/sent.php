<?php
include "./src/components/head.php";
?>

<title>Halaman Dashboard</title>

<!DOCTYPE html>
<html lang="en">

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('send', () => ({
            state: "city",
            districts: [],
            cities: [],
            init() {
                fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json").then(async res => {
                    const provincies = [
                        "DKI JAKARTA",
                        "JAWA BARAT",
                        "JAWA TENGAH",
                        "JAWA TIMUR",
                        "BANTEN"
                    ];
                    const values = await res.json();
                    const selectedProvincies = [];
                    for (const provinci of values) {
                        if (provincies.includes(provinci.name)) selectedProvincies.push(provinci);
                    }

                    for (const provinci of selectedProvincies) {
                        const x = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinci.id}.json`);
                        const values = await x.json();
                        this.cities.push(...values);
                    }
                })
            },
            updateDistricts(event) {
                const client_city = event.target.value;
                this.districts = [];
                for (const city of this.cities) {
                    if (city.name === client_city) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${city.id}.json`).then(async res => {
                            const values = await res.json();
                            this.districts.push(...values);
                        })
                    }
                }
            },
        }));
    })
</script>

<body class="min-h-screen flex flex-col dark:bg-[#121212]">
    <div class="flex flex-col md:flex-row">
        <div class="flex flex-col w-full bg-[#FF9130] dark:bg-[#EE7214] md:w-28 lg:w-[20%] md:h-screen py-4 px-6 gap-4">
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

                <?php if ($role == 1) { ?>
                    <div class="flex flex-col gap-4">
                        <p class="hidden lg:flex uppercase text-white">admin</p>
                        <div class="flex flex-col w-full gap-2">
                            <a href="/admin/kiriman" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                                <i class="lg:w-3 text-white font-bold fa-solid fa-file-invoice-dollar lg:ml-1 text-lg"></i>
                                <p class="hidden lg:flex text-white font-bold text-lg">List Kiriman</p>
                            </a>

                            <a href="/admin/pengguna" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                                <i class="lg:w-3 text-white font-bold fa-solid fa-user lg:ml-1 text-lg"></i>
                                <p class="hidden lg:flex text-white font-bold text-lg">List Pengguna</p>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="p-6 md:p-10 w-full h-screen flex flex-col mt-4 md:mt-0 gap-10 mb-6 md:mb-0">
            <p class="text-2xl font-bold dark:text-white">List Kiriman</p>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="border rounded-lg divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-[#FF9130]">
                                        <tr>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase rounded-tl-lg">Tanggal</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Customer</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Resi</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Barang</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Tujuan</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase rounded-tr-lg">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <?php for ($i = 0; $i < count($results); $i++) { ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"><?= htmlspecialchars($results[$i]["date"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= htmlspecialchars($results[$i]["user"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= htmlentities($results[$i]["resi"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= htmlspecialchars($results[$i]["name"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= htmlspecialchars($results[$i]["city"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    <?php
                                                        $state = $results[$i]["state"];
                                                        if ($state === "on_going") {
                                                            echo "Dalam Perjalanan";
                                                        } else if ($state === "on_hold") {
                                                            echo "Ditahan";
                                                        } else if ($state === "return") {
                                                            echo "Dikembalikan";
                                                        } else if ($state === "done") {
                                                            echo "Dikirim";
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-1 px-4">
                                <nav class="flex items-center space-x-1">
                                    <button type="button" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">Previous</span>
                                    </button>
                                    <button type="button" class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10" aria-current="page">1</button>
                                    <button type="button" class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10">2</button>
                                    <button type="button" class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10">3</button>
                                    <button type="button" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <span class="sr-only">Next</span>
                                        <span aria-hidden="true">»</span>
                                    </button>
                                </nav>
                            </div>
                        </div>
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
                <div class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]" :class="page === 'dashboard' && 'bg-[#b85e20]'">
                    <i class="text-white font-bold fa-solid fa-house text-2xl"></i>
                </div>

                <div class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                    <i class="text-white font-bold fa-solid fa-truck text-2xl"></i>
                </div>

                <div class="flex w-12 h-12 relative justify-center">
                    <div class="flex absolute w-20 h-20 bg-[#FCFCFC] rounded-full -top-10 justify-center">
                        <div class="flex w-16 h-16 bg-[#FF9130] dark:bg-[#EE7214] hover:bg-[#b85e20] rounded-full mt-2 justify-center items-center">
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