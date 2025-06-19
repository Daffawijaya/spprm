<template>
    <div class="relative w-full max-w-md">
        <!-- Ikon Search -->
        <MagnifyingGlassIcon
            class="pointer-events-none absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-[#CCCCCC] focus-within:text-[#ADDC8B]" />

        <!-- Input -->
        <input v-model="searchQuery" @keyup.enter="emitSearch" type="text" placeholder="Cari..."
            class="w-full pl-12 pr-4 py-2 bg-[#F3F5FD] text-gray-800 placeholder-[#CCCCCC] rounded-full focus:outline-none focus:ring-1 focus:ring-[#ADDC8B]" />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'

const emit = defineEmits(['search'])
const searchQuery = ref('')

function emitSearch() {
    emit('search', searchQuery.value)
}
</script>
