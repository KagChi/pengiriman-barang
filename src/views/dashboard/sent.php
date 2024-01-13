<?php
include "./src/components/head.php";
?>

<title>Halaman Dashboard</title>

<!DOCTYPE html>
<html lang="en">

<script>
    function handleFormSubmit(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        fetch("/api/package/confirm", {
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
                        window.location.reload()
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
    }
</script>

<?php for ($i = 0; $i < count($results); $i++) { ?>
    <?php if ($results[$i]["state"] == "done_waiting_confirmation") { ?>
        <dialog id="modal_<?= $results[$i]["id"] ?>" class="bg-[#EEEEEE] dark:bg-[#252525] rounded-xl p-6 shadow-xl">
            <div class="flex flex-col gap-4">
                <h3 class="dark:text-white font-bold text-lg w-96">Perbarui Pengiriman</h3>
                <form class="flex flex-col gap-4" onsubmit="handleFormSubmit(event)">
                    <input hidden value="<?= $csrf ?>" name="csrf_token">
                    <input hidden value="<?= $results[$i]["id"] ?>" name="id">
                    <div class="flex flex-col">
                        <p class="dark:text-white">
                            Konfirmasi pengiriman
                        </p>
                        <select class="rounded" name="state">
                            <option value="" disabled selected>Silahkah pilih</option>
                            <option value="done">
                                Barang diterima
                            </option>
                            <option value="need_action">
                                Barang belum diterima
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-row justify-between mt-12">
                        <button class="bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130] text-[#FCFCFC] px-4 py-2 rounded-md" type="reset" onclick="modal_<?= $results[$i]["id"] ?>.close()">Close</button>
                        <button class="bg-[#FF9130] hover:bg-[#EE7214] dark:bg-[#EE7214] hover:bg-[#FF9130] text-[#FCFCFC] px-4 py-2 rounded-md" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </dialog>

    <?php } ?>
<?php } ?>

<body class="min-h-screen flex flex-col dark:bg-[#121212]">
    <div class="flex flex-col md:flex-row h-auto">
        <div class="flex flex-col w-full bg-[#FF9130] dark:bg-[#EE7214] md:w-28 lg:w-[20%] <?php if (count($results) >= 15) {
                                                                                                echo  "md:h-full";
                                                                                            } else {
                                                                                                echo "md:h-screen";
                                                                                            } ?> py-4 px-6 gap-4">
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
                        <a href="/dashboard/kiriman" class="flex flex-row w-14 lg:w-full h-14 hover:bg-[#b85e20] bg-[#b85e20] rounded-full lg:rounded-xl items-center justify-center lg:justify-start lg:gap-4 px-4 py-4">
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

        <div class="p-6 md:p-10 w-full h-screen md:h-full flex flex-col mt-4 md:mt-0 gap-10 mb-6 md:mb-0 overflow-x-auto">
            <p class="text-2xl font-bold dark:text-white">Kiriman Saya</p>

            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-scroll">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="border rounded-lg divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-[#FF9130]">
                                        <tr>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase rounded-tl-lg">Tanggal</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Tipe</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Resi</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Barang</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Tujuan</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase">Status</th>
                                            <th class="px-6 py-3 text-start font-bold text-white uppercase rounded-tr-lg"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <?php for ($i = 0; $i < count($results); $i++) { ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"><?= htmlspecialchars_decode($results[$i]["date"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    <?php
                                                        $type = $results[$i]["package_type"];
                                                        if ($type == "fragile") {
                                                            echo "Mudah pecah";
                                                        } else if ($type == "food") {
                                                            echo "Makanan";
                                                        } else if ($type == "other") {
                                                            echo "Lainnya";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= htmlspecialchars_decode($results[$i]["resi"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= htmlspecialchars_decode($results[$i]["name"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= htmlspecialchars_decode($results[$i]["city"]) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    <?php
                                                    $state = $results[$i]["state"];
                                                    if ($state == "on_going") {
                                                        echo "Dalam Perjalanan";
                                                    } else if ($state == "on_hold") {
                                                        echo "Ditahan";
                                                    } else if ($state == "return") {
                                                        echo "Dikembalikan";
                                                    } else if ($state == "done") {
                                                        echo "Dikirim";
                                                    } else if ($state == "need_action") {
                                                        echo "Terkendala";
                                                    }
                                                    ?>

                                                    <?php if ($state == "done_waiting_confirmation") { ?>
                                                        <button onclick="modal_<?= $results[$i]["id"] ?>.showModal()">Menunggu Konfirmasi</button>
                                                    <?php } ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500">
                                                    <a href="/dashboard/lacak/<?= $results[$i]["resi"] ?>">Lacak</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
                <a href="/dashboard" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
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

                <a href="/dashboard/kiriman" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20] bg-[#b85e20]">
                    <i class="text-white font-bold fa-solid fa-file-invoice-dollar text-2xl"></i>
                </a>

                <a href="/logout" class="flex w-12 h-12 rounded-full mt-2 justify-center items-center hover:bg-[#b85e20]">
                    <i class="text-white font-bold fa-solid fa-right-from-bracket text-2xl"></i>
                </a>
            </div>
        </footer>
</body>

</html>