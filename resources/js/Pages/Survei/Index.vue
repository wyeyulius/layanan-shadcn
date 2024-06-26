<script setup lang="ts">
import { Head, router, usePage } from "@inertiajs/vue3";
import { reactive, ref, computed, onMounted } from "vue";
import { Button } from "@/Components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Progress } from "@/Components/ui/progress";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from "@/Components/ui/drawer";

// Create a new Date object
const currentDate = new Date();

// Get the current year
const currentYear = currentDate.getFullYear();

const props = defineProps({
    statistik: {
        type: Object,
        default: () => ({}), // Provide an empty object as default value
    },
});

const countdown = ref(5);
let redirectTimer: number | undefined;

const open = ref(false);
const progressBarWidth = ref(0);
const page = usePage();
const message = computed(() => page.props.flash.message);

onMounted(() => {
    const interval = 50; // Update every 50 milliseconds for smoother progress bar
    const totalSteps = (countdown.value * 1000) / interval;
    let currentStep = 0;
    if (message.value != null) {
        open.value = true;
    }
    redirectTimer = window.setInterval(() => {
        countdown.value -= interval / 1000;
        currentStep++;

        if (countdown.value <= 0) {
            clearInterval(redirectTimer);
            open.value = false;
        }

        progressBarWidth.value = (currentStep / totalSteps) * 100;
    }, interval);
});

const noCheckboxChecked = computed(() => form.checkedLayanans.length === 0);
const form = reactive({
    checkedLayanans: ref([]),
    nilai: null,
});

function submit() {
    router.post("/survei", form, {
        preserveState: false,
        preserveScroll: false,
    });
}
</script>

<template>
    <Head title="Survei" />
    <Drawer v-model:open="open">
        <DrawerContent>
            <DrawerHeader>
                <Progress :model-value="progressBarWidth" />
                <DrawerTitle class="text-center">
                    <h1 v-if="message == '1'" class="text-4xl font-bold">
                        Terima kasih atas penilaian anda !
                    </h1>
                    <h1 v-if="message == '2'" class="text-4xl font-bold">
                        Terima kasih, masukan bagi kami !
                    </h1>
                    <h1 v-if="message == '3'" class="text-4xl font-bold">
                        Terima kasih, akan segera kami perbaiki !
                    </h1>
                </DrawerTitle>
                <DrawerDescription
                    ><div class="flex items-center justify-center text-xl">
                        <div>
                            <div
                                v-if="message == '1'"
                                class="flex flex-col items-center space-y-2"
                            >
                                <img
                                    src="@img/baik.png"
                                    alt="Baik"
                                    class="py-5 mx-auto h-50 w-50 object-cover"
                                />
                                <p>
                                    Kami sangat senang, anda memberikan
                                    penilaian terbaik buat kami. Akan kami
                                    pertahankan layanan kami.
                                </p>
                            </div>
                            <div
                                v-else-if="message == '2'"
                                class="flex flex-col items-center space-y-2"
                            >
                                <img
                                    src="@img/cukup.png"
                                    alt="Cukup"
                                    class="py-5 mx-auto h-50 w-50 object-cover"
                                />
                                <p>
                                    Anda telah memberi masukan bagi kami untuk
                                    memperbaiki beberapa layanan untuk kepuasan
                                    anda
                                </p>
                            </div>
                            <div
                                v-else-if="message == '3'"
                                class="flex flex-col items-center space-y-2"
                            >
                                <img
                                    src="@img/buruk.png"
                                    alt="Buruk"
                                    class="py-5 mx-auto h-50 w-50 object-cover"
                                />
                                <p>
                                    Kami akan memperbaiki layanan kami agar
                                    memberikan pelayanan yang terbaik untuk anda
                                </p>
                            </div>
                        </div>
                    </div>
                </DrawerDescription>
            </DrawerHeader>
        </DrawerContent>
    </Drawer>

    <div class="h-screen pb-12 sm:pb-0 relative scroll-smooth perspective">
        <nav
            class="grid place-items-center absolute w-full top-0 z-50 drop-shadow-text-sm"
            aria-label="Primary Navigation"
        >
            <a
                href="/"
                aria-label="Go Home"
                class="p-1 m-4 focus:outline-none focus-visible:ring-4 ring-accent rounded-full transition-shadow"
            >
                <img
                    class="w-12 sm:w-16 lg:w-24"
                    src="@img/bps.svg"
                    alt="logo"
                />
            </a>
        </nav>
        <div
            class="h-4/5 mb-5 leading-normal tracking-normal text-white gradient"
        >
            <div data-aos="fade-up" class="pt-20 pl-40">
                <div
                    class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center"
                >
                    <div
                        class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left"
                    >
                        <p class="uppercase tracking-loose w-full">
                            PST BPS PROVINSI SULAWESI UTARA
                        </p>
                        <h1 class="my-4 text-5xl font-bold leading-tight">
                            Survei Kepuasan Layanan
                        </h1>
                        <p class="leading-normal text-2xl mb-8">
                            Mohon untuk meluangkan waktu sejenak untuk mengisi
                            survei singkat tentang layanan yang sudah diterima.
                        </p>
                        <Button
                            variant="alternate"
                            v-on:click="scrollToElement()"
                        >
                            Mulai
                        </Button>
                    </div>
                    <div class="w-full md:w-3/5 py-6 text-center">
                        <img class="w-full md:w-4/5 z-50" src="@img/hero.png" />
                    </div>
                </div>
            </div>
        </div>
        <div data-aos="fade-up" id="statistik" class="container pb-5 stat">
            <Card class="divide-y divide-solid">
                <CardHeader>
                    <CardTitle class="text-center text-2xl text-slate-500"
                        >Statistik Layanan {{ currentYear }}</CardTitle
                    >
                </CardHeader>
                <CardContent>
                    <div class="mt-2 grid grid-cols-6 gap-4">
                        <div class="text-center">
                            <h1 class="text-5xl font-bold text-blue-800">
                                {{
                                    statistik.perpustakaan !== null
                                        ? statistik.perpustakaan
                                        : 0
                                }}
                            </h1>
                            <p class="text-slate-700">Kunjungan Perpustakaan</p>
                        </div>
                        <div class="text-center">
                            <h1 class="text-5xl font-bold text-blue-800">
                                {{
                                    statistik.konsultasi !== null
                                        ? statistik.konsultasi
                                        : 0
                                }}
                            </h1>
                            <p class="text-slate-700">
                                Kunjungan Konsultasi Statistik
                            </p>
                        </div>
                        <div class="text-center">
                            <h1 class="text-5xl font-bold text-blue-800">
                                {{
                                    statistik.penjualan !== null
                                        ? statistik.penjualan
                                        : 0
                                }}
                            </h1>
                            <p class="text-slate-700">
                                Kunjungan Penjualan Produk Statistik
                            </p>
                        </div>
                        <div class="text-center">
                            <h1 class="text-5xl font-bold text-blue-800">
                                {{
                                    statistik.rekomendasi !== null
                                        ? statistik.rekomendasi
                                        : 0
                                }}
                            </h1>
                            <p class="text-slate-700">
                                Kunjungan Rekomendasi Statistik
                            </p>
                        </div>
                        <div class="text-center">
                            <h1 class="text-5xl font-bold text-blue-800">
                                {{
                                    statistik.umum !== null ? statistik.umum : 0
                                }}
                            </h1>
                            <p class="text-slate-700">Kunjungan Umum</p>
                        </div>
                        <div class="text-center">
                            <h1 class="text-5xl font-bold text-blue-800">
                                {{
                                    statistik.pengaduan !== null
                                        ? statistik.pengaduan
                                        : 0
                                }}
                            </h1>
                            <p class="text-slate-700">Kunjungan Pengaduan</p>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
        <div id="layanan" class="mt-10 relative h-full mx-auto max-w-5xl">
            <form @submit.prevent>
                <div data-aos="zoom-in" class="py-5 text-center text-blue-500">
                    <h1 class="my-4 text-2xl font-bold leading-tight">
                        Pilih Layanan yang telah diterima
                    </h1>
                </div>
                <div class="flex flex-wrap justify-center gap-8">
                    <label data-aos="fade-up" class="relative cursor-pointer">
                        <input
                            type="checkbox"
                            id="layanan-1"
                            value="1"
                            v-model="form.checkedLayanans"
                            class="peer sr-only"
                            name="size-choice"
                        />
                        <span
                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="fill-blue-500 stroke-white"
                                width="32"
                                height="32"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#2c3e50"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <circle cx="12" cy="12" r="9" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </span>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-md ring ring-transparent grayscale transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                        >
                            <div>
                                <img
                                    src="@img/layanan-1.svg"
                                    alt="Layanan 1"
                                    class="h-24 w-24 md:h-32 md:w-32 lg:w-60 lg:h-60 object-cover"
                                />
                            </div>
                        </div>
                    </label>

                    <label data-aos="fade-up" class="relative cursor-pointer">
                        <input
                            type="checkbox"
                            id="layanan-2"
                            value="2"
                            v-model="form.checkedLayanans"
                            class="peer sr-only"
                            name="size-choice"
                        />
                        <span
                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="fill-blue-500 stroke-white"
                                width="32"
                                height="32"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#2c3e50"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <circle cx="12" cy="12" r="9" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </span>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-md ring ring-transparent grayscale transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                        >
                            <div>
                                <img
                                    src="@img/layanan-2.svg"
                                    alt="Layanan 2"
                                    class="h-24 w-24 md:h-32 md:w-32 lg:w-60 lg:h-60 object-cover"
                                />
                            </div>
                        </div>
                    </label>
                    <label data-aos="fade-up" class="relative cursor-pointer">
                        <input
                            type="checkbox"
                            id="layanan-3"
                            value="3"
                            v-model="form.checkedLayanans"
                            class="peer sr-only"
                            name="size-choice"
                        />
                        <span
                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="fill-blue-500 stroke-white"
                                width="32"
                                height="32"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#2c3e50"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <circle cx="12" cy="12" r="9" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </span>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-md ring ring-transparent grayscale transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                        >
                            <div>
                                <img
                                    src="@img/layanan-3.svg"
                                    alt="Layanan 3"
                                    class="h-24 w-24 md:h-32 md:w-32 lg:w-60 lg:h-60 object-cover"
                                />
                            </div>
                        </div>
                    </label>
                    <label data-aos="fade-up" class="relative cursor-pointer">
                        <input
                            type="checkbox"
                            id="layanan-4"
                            value="4"
                            v-model="form.checkedLayanans"
                            class="peer sr-only"
                            name="size-choice"
                        />
                        <span
                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="fill-blue-500 stroke-white"
                                width="32"
                                height="32"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#2c3e50"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <circle cx="12" cy="12" r="9" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </span>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-md ring ring-transparent grayscale transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                        >
                            <div>
                                <img
                                    src="@img/layanan-4.svg"
                                    alt="Layanan 4"
                                    class="h-24 w-24 md:h-32 md:w-32 lg:w-60 lg:h-60 object-cover"
                                />
                            </div>
                        </div>
                    </label>
                    <label data-aos="fade-up" class="relative cursor-pointer">
                        <input
                            type="checkbox"
                            id="layanan-5"
                            value="5"
                            v-model="form.checkedLayanans"
                            class="peer sr-only"
                            name="size-choice"
                        />
                        <span
                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="fill-blue-500 stroke-white"
                                width="32"
                                height="32"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#2c3e50"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <circle cx="12" cy="12" r="9" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </span>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-md ring ring-transparent grayscale transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                        >
                            <div>
                                <img
                                    src="@img/layanan-5.svg"
                                    alt="Layanan 5"
                                    class="h-24 w-24 md:h-32 md:w-32 lg:w-60 lg:h-60 object-cover"
                                />
                            </div>
                        </div>
                    </label>
                    <label data-aos="fade-up" class="relative cursor-pointer">
                        <input
                            type="checkbox"
                            id="layanan-6"
                            value="6"
                            v-model="form.checkedLayanans"
                            class="peer sr-only"
                            name="size-choice"
                        />
                        <span
                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="fill-blue-500 stroke-white"
                                width="32"
                                height="32"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#2c3e50"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <circle cx="12" cy="12" r="9" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </span>
                        <div
                            class="overflow-hidden rounded-lg bg-white shadow-md ring ring-transparent grayscale transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                        >
                            <div>
                                <img
                                    src="@img/layanan-6.svg"
                                    alt="Layanan 6"
                                    class="h-24 w-24 md:h-32 md:w-32 lg:w-60 lg:h-60 object-cover"
                                />
                            </div>
                        </div>
                    </label>
                </div>
                <div data-aos="fade-up" class="my-5 text-center">
                    <Dialog>
                        <DialogTrigger :disabled="noCheckboxChecked">
                            <Button
                                variant="tertiary"
                                :disabled="noCheckboxChecked"
                            >
                                Isi survei
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>
                                    <div class="text-2xl text-center">
                                        Silakan pilih sesuai layanan kami
                                    </div>
                                </DialogTitle>
                                <DialogDescription>
                                    <div
                                        class="my-5 divide-y divide-solid"
                                    ></div>
                                </DialogDescription>
                                <div
                                    class="flex flex-wrap justify-center gap-10"
                                >
                                    <label class="relative cursor-pointer">
                                        <input
                                            type="radio"
                                            id="nilai-baik"
                                            value="1"
                                            v-model="form.nilai"
                                            class="peer sr-only"
                                            name="size-choice"
                                        />
                                        <span
                                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="fill-blue-500 stroke-white"
                                                width="32"
                                                height="32"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="#2c3e50"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                />
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M9 12l2 2l4 -4" />
                                            </svg>
                                        </span>
                                        <div
                                            class="h-80 w-80 overflow-hidden rounded-lg bg-white ring ring-transparent transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                                        >
                                            <div class="mt-5">
                                                <img
                                                    src="@img/baik.png"
                                                    alt="Baik"
                                                    class="mx-auto h-50 w-50 object-cover"
                                                />
                                            </div>
                                            <header
                                                class="px-2.5 py-2.5 text-center"
                                            >
                                                <p
                                                    class="text-2xl font-bold tracking-wide text-gray-700"
                                                >
                                                    Baik
                                                </p>
                                            </header>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input
                                            type="radio"
                                            id="nilai-cukup"
                                            value="2"
                                            v-model="form.nilai"
                                            class="peer sr-only"
                                            name="size-choice"
                                        />
                                        <span
                                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="fill-blue-500 stroke-white"
                                                width="32"
                                                height="32"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="#2c3e50"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                />
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M9 12l2 2l4 -4" />
                                            </svg>
                                        </span>
                                        <div
                                            class="h-80 w-80 overflow-hidden rounded-lg bg-white ring ring-transparent transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                                        >
                                            <div class="mt-5">
                                                <img
                                                    src="@img/cukup.png"
                                                    alt="Cukup"
                                                    class="mx-auto h-50 w-50 object-cover"
                                                />
                                            </div>
                                            <header
                                                class="px-2.5 py-2.5 text-center"
                                            >
                                                <p
                                                    class="text-2xl font-bold tracking-wide text-gray-700"
                                                >
                                                    Cukup
                                                </p>
                                            </header>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input
                                            type="radio"
                                            id="nilai-buruk"
                                            value="3"
                                            v-model="form.nilai"
                                            class="peer sr-only"
                                            name="size-choice"
                                        />
                                        <span
                                            class="absolute top-2 right-2 z-10 opacity-0 transition-all peer-checked:opacity-100"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="fill-blue-500 stroke-white"
                                                width="32"
                                                height="32"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="#2c3e50"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                />
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M9 12l2 2l4 -4" />
                                            </svg>
                                        </span>
                                        <div
                                            class="h-80 w-80 overflow-hidden rounded-lg bg-white ring ring-transparent transition-all active:scale-95 peer-checked:ring-blue-500 peer-checked:grayscale-0"
                                        >
                                            <div class="mt-5">
                                                <img
                                                    src="@img/buruk.png"
                                                    alt="Buruk"
                                                    class="mx-auto h-50 w-50 object-cover"
                                                />
                                            </div>
                                            <header
                                                class="px-2.5 py-2.5 text-center"
                                            >
                                                <p
                                                    class="text-2xl font-bold tracking-wide text-gray-700"
                                                >
                                                    Buruk
                                                </p>
                                            </header>
                                        </div>
                                    </label>
                                </div>
                            </DialogHeader>
                            <DialogFooter>
                                <Button
                                    class="mt-5 w-1/5"
                                    type="submit"
                                    @click="submit"
                                    variant="tertiary"
                                    >Kirim Penilaian</Button
                                >
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts">
import AOS from "aos";

export default {
    methods: {
        scrollToElement() {
            const el = document.getElementById("layanan");

            if (el) {
                el.scrollIntoView({ behavior: "smooth" });
            }
        },
    },
    mounted() {
        AOS.init({
            duration: 1000, // values from 0 to 3000, with step 50ms
            easing: "ease", // default easing for AOS animations
            once: false, // whether animation should happen only once - while scrolling down
        });
    },
};
</script>
