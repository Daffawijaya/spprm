<template>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex flex-col">

        <!-- Navbar (full-width) -->
        <nav
            class="fixed top-0 w-full flex justify-between items-center px-4 py-4 bg-white/70 backdrop-blur-md z-50 shadow-sm">
            <h1 class="text-3xl font-bold text-blue-600">TerapiKu</h1>
            <div class="space-x-4">
                <router-link to="/login">
                    <button class="bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700">Masuk</button>
                </router-link>

            </div>
        </nav>

        <!-- Hero (full-width background) -->
        <section class="pt-28 pb-16 px-4 md:flex md:items-center md:justify-between">
            <div class="container mx-auto max-w-screen-xl flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-xl space-y-6">
                    <h2 class="text-5xl font-extrabold text-gray-800">
                        Kelola & Reschedule Jadwal Terapi dengan Cepat
                    </h2>
                    <p class="text-lg text-gray-600">
                        Cek jadwal, ubah sesi, dan konsultasi virtual—semuanya dalam satu aplikasi intuitif.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <router-link to="/dashboard">
                            <button class="bg-green text-white px-6 py-3 rounded-full hover:bg-green-600">
                                Lihat Jadwal
                            </button>
                        </router-link>
                        <router-link to="/dashboard?reschedule=true">
                            <button class="bg-orange text-white px-6 py-3 rounded-full hover:bg-orange-600">
                                Reschedule
                            </button>
                        </router-link>
                        <router-link to="/telehealth">
                            <button class="bg-purple text-white px-6 py-3 rounded-full hover:bg-purple-700">
                                Konsultasi Virtual
                            </button>
                        </router-link>
                    </div>
                </div>
                <img src="http://localhost:8000/image/ilus.png" alt="Ilustrasi Telehealth"
                    class="w-72 md:w-96 mx-auto md:mx-0" />
            </div>
        </section>

        <!-- Fitur (inside container) -->
        <section class="bg-white py-16">
            <div class="container mx-auto max-w-screen-xl max-w-screen-xl">
                <h3 class="text-3xl font-semibold text-center text-gray-800 mb-12">Fitur Unggulan Pasien</h3>
                <div class="grid md:grid-cols-4 gap-6">
                    <FeatureCard :icon="CalendarIcon" title="Lihat Jadwal" desc="Pantau jadwal harian & mingguan"
                        color="blue" />
                    <FeatureCard :icon="PencilSquareIcon" title="Reschedule" desc="Ubah sesi kapan saja"
                        color="green" />
                    <FeatureCard :icon="BellIcon" title="Notifikasi" desc="Pengingat otomatis sebelum sesi"
                        color="orange" />
                    <FeatureCard :icon="VideoCameraIcon" title="Konsultasi Virtual" desc="Sesi online lewat video call"
                        color="purple" />
                </div>
            </div>
        </section>

        <!-- Statistik (inside container) -->
        <section class="bg-blue-50 py-12">
            <div class="container mx-auto max-w-screen-xl">
                <div class="flex flex-wrap justify-center gap-12 text-center">
                    <StatCard num="+1.200" label="Pasien Terdaftar" color="blue" />
                    <StatCard num="98%" label="Kepuasan Pasien" color="green" />
                    <StatCard num="24/7" label="Dukungan & Reminder" color="orange" />
                    <StatCard num="500+" label="Konsultasi Virtual" color="purple" />
                </div>
            </div>
        </section>

        <!-- Cara Kerja (inside container) -->
        <section class="py-16">
            <div class="container mx-auto max-w-screen-xl">
                <h3 class="text-3xl font-semibold text-center text-gray-800 mb-12">Cara Kerja</h3>
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2">1</div>
                        <p>Pilih jadwal & sesi yang tersedia</p>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-600 mb-2">2</div>
                        <p>Klik reschedule atau mulai sesi virtual</p>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-orange-600 mb-2">3</div>
                        <p>Terima notifikasi & konfirmasi otomatis</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial (inside container) -->
        <section class="py-16 bg-white">
            <div class="container mx-auto max-w-screen-xl">
                <h3 class="text-3xl font-semibold text-center text-gray-800 mb-12">Testimonial Pasien</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <Testimonial name="Siti" msg="Reschedule sekarang super gampang dan fleksibel!" rating="5" />
                    <Testimonial name="Andi" msg="Notifikasi tepat waktu bikin saya nggak telat." rating="5" />
                    <Testimonial name="Lina" msg="Konsultasi virtual sangat membantu saat jam sibuk." rating="5" />
                </div>
            </div>
        </section>

        <section class="py-6">
            <div class="container mx-auto max-w-screen-xl">
                <div class="flex justify-center items-center gap-4">
                    <img src="http://localhost:8000/image/LOGOdKKRI.png" alt="Logo" class="h-8 object-contain" />
                    <img src="http://localhost:8000/image/Rectangle486.png" alt="Rectangle"
                        class="h-8 object-contain" />
                </div>
            </div>
        </section>
        <!-- Footer (full-width) -->
        <footer class="bg-gray-100 text-center py-6 text-sm text-gray-600">
            &copy; 2025 TerapiKu • <a href="#" class="hover:text-blue-600">Privasi & Ketentuan</a>
        </footer>

    </div>
</template>

<script setup>
import {
    CalendarIcon,
    PencilSquareIcon,
    BellIcon,
    VideoCameraIcon
} from '@heroicons/vue/24/outline'
import FeatureCard from '@/components/landing/FeatureCard.vue'
import StatCard from '@/components/landing/StatCard.vue'
import Testimonial from '@/components/landing/Testimonial.vue'
</script>
