<template>
  <div class="w-full max-w-md">
    <input
      v-model="searchQuery"
      @keyup.enter="emitSearch"
      type="text"
      placeholder="Cari..."
      class="w-full px-4 py-2 bg-[#F3F5FD] text-gray-800 placeholder-[#CCCCCC] rounded-full focus:outline-none focus:ring-1 focus:ring-[#ADDC8B]"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'

const emit = defineEmits(['search'])
const searchQuery = ref('')

function emitSearch() {
  emit('search', searchQuery.value)
}
</script>
