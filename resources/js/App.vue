<template>
  <div class="flex bg-[#EFF2F9]">
    <!-- Sticky Sidebar -->
    <div class="fixed top-0 left-0 h-screen w-48 z-50">
      <Sidebar />
    </div>

    <!-- Konten Utama -->
    <div class="ml-48 p-7 flex-1 space-y-2 min-h-screen">
      <Navbar />
      <Breadcrumb />
      <router-view />
    </div>
  </div>
</template>


<script>
import Sidebar from './components/Sidebar.vue';
import Navbar from './components/Navbar.vue'
import Breadcrumb from './components/Breadcrumb.vue'

export default {
  name: 'App',
  components: { Sidebar, Navbar, Breadcrumb }
};
</script>
