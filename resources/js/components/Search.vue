<template>
  <div class="flex items-center gap-2 w-full max-w-md">
    <input
      v-model="searchQuery"
      @keyup.enter="emitSearch"
      type="text"
      placeholder="Cari pasien..."
      class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
    />
    <button
      @click="emitSearch"
      class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition"
    >
      Cari
    </button>
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