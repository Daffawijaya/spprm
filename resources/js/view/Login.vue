<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-white px-4">
    <div class="max-w-6xl w-full grid md:grid-cols-2 gap-8 items-center">
      <!-- Ilustrasi -->
      <div class="hidden md:flex justify-center">
        <img src="http://localhost:8000/image/ilus.png" alt="Ilustrasi Login" class="w-[80%]" />
      </div>

      <!-- Card Login -->
      <div class="bg-white rounded-2xl shadow-xl px-10 py-10 w-full max-w-md mx-auto flex flex-col">
        <!-- Judul -->
        <h2 class="text-3xl font-bold text-blue-700 text-center mb-6">Masuk ke TerapiKu</h2>

        <!-- Form -->
        <form class="space-y-5 w-full">
          <!-- Username -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
            <div
              class="flex items-center bg-[#F3F5FD] rounded-full px-4 py-2 focus-within:ring-2 focus-within:ring-[#ADDC8B]">
              <UserIcon class="w-5 h-5 text-gray-700 mr-2" />
              <input type="text" placeholder="Masukkan username"
                     class="w-full bg-transparent text-gray-800 placeholder-[#CCCCCC] focus:outline-none" />
            </div>
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <div
              class="flex items-center bg-[#F3F5FD] rounded-full px-4 py-2 focus-within:ring-2 focus-within:ring-[#ADDC8B]">
              <LockClosedIcon class="w-5 h-5 text-gray-700 mr-2" />
              <input :type="showPassword ? 'text' : 'password'" placeholder="Masukkan password"
                     class="w-full bg-transparent text-gray-800 placeholder-[#CCCCCC] focus:outline-none" />
              <EyeIcon v-if="!showPassword" class="w-5 h-5 text-gray-700 cursor-pointer ml-2" @click="togglePassword" />
              <EyeSlashIcon v-else class="w-5 h-5 text-gray-700 cursor-pointer ml-2" @click="togglePassword" />
            </div>
          </div>

          <!-- Ingat saya -->
          <div class="flex items-center">
            <input type="checkbox" id="remember" class="rounded text-green mr-2 focus:ring-0" />
            <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
          </div>

          <!-- Tombol -->
          <button type="submit"
                  class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-full font-semibold">
            Masuk
          </button>
        </form>

        <!-- Logo bawah -->
        <div class="mt-8 flex justify-center items-center gap-2">
          <img src="http://localhost:8000/image/LOGOdKKRI.png" alt="Logo" class="h-7 object-contain" />
          <img src="http://localhost:8000/image/Rectangle486.png" alt="Rect" class="h-7 object-contain" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { UserIcon, LockClosedIcon, EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid'

const showPassword = ref(false)
const togglePassword = () => {
  showPassword.value = !showPassword.value
}
</script>
