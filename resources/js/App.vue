<template>
    <div>
        <!-- Layout utama (Sidebar + Navbar) hanya untuk halaman selain Landing dan Login -->
        <div v-if="!isPublicPage" class="flex bg-[#EFF2F9]">
            <!-- Sidebar -->
            <div class="fixed top-0 left-0 h-screen w-48 z-50">
                <Sidebar />
            </div>

            <!-- Konten utama -->
            <div class="ml-48 flex-1 min-h-screen">
                <!-- Wrapper konten -->

                <!-- Navbar sticky -->
                <div class="sticky top-0 z-30">
                    <Navbar />
                </div>
                <div class="p-7 space-y-2">
                    <!-- Breadcrumb dan konten -->
                    <Breadcrumb />
                    <router-view />
                </div>
            </div>
        </div>

        <!-- Halaman publik tanpa Sidebar/Navbar -->
        <div v-else>
            <router-view />
        </div>
    </div>
</template>

<script setup>
import { useRoute } from "vue-router";
import { computed } from "vue";
import Sidebar from "./components/Sidebar.vue";
import Navbar from "./components/Navbar.vue";
import Breadcrumb from "./components/Breadcrumb.vue";

// Nama route yang tidak perlu Sidebar/Navbar
const PUBLIC_ROUTES = ["LandingPage", "Login", "Signup"];

const route = useRoute();
const isPublicPage = computed(() => PUBLIC_ROUTES.includes(route.name));
</script>
