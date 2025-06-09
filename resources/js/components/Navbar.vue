<template>
    <div class="p-4 flex justify-end">
    <div class="relative"  @click="toggleDropdown" style="cursor: pointer; ">
     <img src="http://localhost:8000/image/default-profile.jpg" alt="Foto Profil" class="w-10 h-10 rounded-full" />
    <div class="absolute right-0 mt-2 bg-white rounded-full shadow-md px-4 py-1" v-if="showDropdown " >
      <button class="flex gap-x-1 items-center text-sm" @click="logout" style="cursor: pointer;">
        Keluar
        <ArrowRightStartOnRectangleIcon class="size-5" />
      </button>
    </div>
  </div>
  </div>
   
</template>

<script>
import { ArrowRightStartOnRectangleIcon } from '@heroicons/vue/24/outline'

export default {
    components: {
     ArrowRightStartOnRectangleIcon
  },
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