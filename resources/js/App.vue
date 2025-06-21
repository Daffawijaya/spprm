<template>
  <div>
    <!-- Layout utama (Sidebar + Navbar) hanya untuk halaman selain Landing dan Login -->
    <div v-if="!isPublicPage" class="flex bg-[#EFF2F9]">
      <div class="fixed top-0 left-0 h-screen w-48 z-50">
        <Sidebar />
      </div>
      <div class="ml-48 p-7 flex-1 space-y-2 min-h-screen">
        <Navbar />
        <Breadcrumb />
        <router-view />
      </div>
    </div>

    <!-- Halaman tanpa Sidebar/Navbar (Landing, Login, Signup, dll) -->
    <div v-else>
      <router-view />
    </div>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import Sidebar from './components/Sidebar.vue'
import Navbar from './components/Navbar.vue'
import Breadcrumb from './components/Breadcrumb.vue'

// Nama route yang tidak perlu Sidebar/Navbar
const PUBLIC_ROUTES = ['LandingPage', 'Login', 'Signup']

const route = useRoute()
const isPublicPage = computed(() => PUBLIC_ROUTES.includes(route.name))
</script>
