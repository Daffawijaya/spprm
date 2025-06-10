<template>
  <div class="flex">
    <Sidebar />

    <div class="p-7 flex-1">
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

