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
                        <a href="/dashboard/kirim" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
                            <i class="lg:w-4 text-white font-bold fa-solid fa-paper-plane text-lg"></i>
                            <p class="hidden lg:flex text-white font-bold text-lg">Kirim</p>
                        </a>
                        <a href="/dashboard/pesanan" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
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
                <?php } ?>
            </div>
        </div>

        <form class="p-6 md:p-10 w-full h-full flex flex-col mt-4 md:mt-0 gap-10 mb-6 md:mb-0" x-data="{ next: false, state: 'city', city: 'none', district: 'none' }">
            <p class="text-6xl font-extrabold text-[#FF9130] dark:text-white">Kirim Kuy</p>

            <div data-aos="fade-up" class="flex flex-col gap-y-4 md:gap-y-0 md:flex-row justify-between md:mt-2 gap-x-10">
                <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-show="!next" class="flex flex-col w-full gap-5 md:gap-4">
                    <div class="flex flex-col gap-2">
                        <p class="font-bold dark:text-white">Nama Penerima</p>
                        <input class="border border-2 rounded-lg px-3 font-bold h-8" name="receiver" placeholder="Masukan nama penerima">
                    </div>

                    <div class="flex flex-col">
                        <p class="font-bold dark:text-white">Nama Barang</p>
                        <input class="border rounded-md p-2" placeholder="Masukan nama barang">
                    </div>

                    <div x-data="send" class="flex flex-col gap-5 md:gap-4 bg-[#FF9130] rounded-lg p-3">
                        <p class="text-white font-bold dark:text-white">Silahkan pilih Kota/Kabupaten & Kecamatan</p>
                        <div class="flex flex-col justify-between gap-4">
                            <select x-show="cities.length > 0" @change="updateDistricts" @click="state = 'city' " :class="state === 'city' && 'bg-[#b85e20]'" class="bg-[#FF9130] cursor-pointer flex justify-center items-center border border-white rounded-md p-2 w-full text-white font-bold" name="cities">
                                <option class="text-[#FF9130]" value="" disabled selected>Kota/Kabupaten</option>
                                <template x-for="city in cities" :key="city.id">
                                    <option x-text="city.name" class="hover:bg-[#FF9130]"></option>
                                </template>
                            </select>

                            <select x-show="districts.length > 0" @click="state = 'district' " :class="state === 'district' && 'bg-[#b85e20]'" class="bg-[#FF9130] cursor-pointer flex justify-center items-center border border-white rounded-md p-2 w-full text-white font-bold" name="districts">
                                <option class="text-[#FF9130] rounded-md" value="" disabled selected>Kecamatan</option>
                                <template x-for="district in districts" :key="district.id">
                                    <option x-text="district.name" class="hover:bg-[#FF9130]"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <p class="font-bold dark:text-white">Alamat Lengkap</p>
                        <textarea class="border border-2 rounded-lg px-3 py-1 font-bold h-24" placeholder="Masukan alamat lengkap"></textarea>
                    </div>

                    <a type="button" @click="next = ! next" class="cursor-pointer flex flex-row justify-center items-center w-32 h-10 ml-auto bg-[#ef5941] rounded-lg gap-4 px-4">
                        <p class="text-white font-bold">Lanjut</p>
                        <i class="text-white fa-solid fa-paper-plane"></i>
                    </a>
                </div>

                <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-show="next" class="flex flex-col gap-5 md:gap-4 w-full">
                    <div class="flex flex-col">
                        <p class="font-bold dark:text-white">Jumlah Barang</p>
                        <input class="border rounded-md p-2" type="number" placeholder="Masukan jumlah barang">
                    </div>

                    <div class="flex flex-col">
                        <p class="font-bold dark:text-white">Berat</p>
                        <input class="border rounded-md p-2" placeholder="Masukan berat barang (Kg)">
                    </div>

                    <div class="flex flex-col gap-2">
                        <p class="font-bold dark:text-white">Notes</p>
                        <textarea class="border border-2 rounded-lg px-3 py-1 font-bold h-48" placeholder="Masukan note tambahan"></textarea>
                    </div>

                    <div class="flex flex-row justify-between">
                        <a type="button" @click="next = ! next" class="cursor-pointer flex flex-row-reverse justify-center items-center w-32 h-10 bg-[#ef5941] rounded-lg gap-4 px-4">
                            <p class="text-white font-bold">Kembali</p>
                            <i class="text-white fa-solid fa-chevron-left"></i>
                        </a>
                        <button type="submit" class="cursor-pointer flex flex-row justify-center items-center w-auto h-10 bg-[#ef5941] rounded-lg gap-4 px-4">
                            <p class="text-white font-bold">Kirim</p>
                            <i class="text-white fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
    </div>
    </form>

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