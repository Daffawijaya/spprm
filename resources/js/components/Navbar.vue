<template>
    <div class="p-4 flex justify-end">
    <div class="relative"  @click="toggleDropdown" style="cursor: pointer; ">
     <img src="http://localhost:8000/image/default-profile.jpg" alt="Foto Profil" class="w-10 h-10 rounded-full" />
    <div class="absolute right-0 mt-2 bg-white rounded-full shadow-md px-3 py-1" v-if="showDropdown " >
      <button @click="logout" style="cursor: pointer;">
        Keluar
      </button>
    </div>
  </div>
  </div>
   
</template>

<script>
export default {
  data() {
    return {
      showDropdown: false
    }
  },
  methods: {
    toggleDropdown() {
      this.showDropdown = !this.showDropdown
    },
    logout() {
      alert('Logout berhasil (contoh sederhana)')
      // Misal hapus token dan arahkan ke login
      localStorage.removeItem('token')
      this.$router.push({ name: 'Login' })
    }
  }
}
</script>