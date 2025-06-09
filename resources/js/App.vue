<template>
  <div class="app-container flex">
    <Sidebar />

    <div class="content p-7 flex-1">
      <Navbar />
      <router-view />
    </div>
  </div>
</template>

<script>
import Sidebar from './components/Sidebar.vue';
import Navbar from './components/Navbar.vue'

export default {
  name: 'App',
  components: { Sidebar, Navbar }
};
</script>

<style scoped>
.app-container {
  min-height: 100vh;
}

.content {
  background: #f9f9f9;
}
</style>