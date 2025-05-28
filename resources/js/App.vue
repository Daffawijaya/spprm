<template>
  <div class="app-container flex">
    <Sidebar />
    <div class="content p-4 flex-1">
      <router-view />
    </div>
  </div>
</template>

<script>
import Sidebar from './components/Sidebar.vue';
export default {
  name: 'App',
  components: { Sidebar }
};
</script>

<style scoped>
.app-container { min-height: 100vh; }
.content { background: #f9f9f9; }
</style>