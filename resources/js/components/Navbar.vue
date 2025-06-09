<template>
  <div style="display: flex; justify-content: flex-end; padding: 10px; background: #f8f8f8; position: relative;">
    <div @click="toggleDropdown" style="cursor: pointer;">
     <img src="http://localhost:8000/profile.jpg" alt="Foto Profil" style="width: 40px; height: 40px; border-radius: 50%;" />
    </div>

    <div v-if="showDropdown" style="position: absolute; top: 60px; right: 10px; background: white; border: 1px solid #ccc; border-radius: 5px; width: 100px;">
      <button @click="logout" style="padding: 10px; width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
        Logout
      </button>
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