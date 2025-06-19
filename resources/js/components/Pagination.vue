<template>
  <div class="flex items-center justify-end gap-2 mt-4">
    <button
      :disabled="currentPage === 1"
      @click="changePage(currentPage - 1)"
      class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50"
    >
      ‹
    </button>

    <span class="text-sm text-gray-700">
      Halaman {{ currentPage }} dari {{ totalPages }}
    </span>

    <button
      :disabled="currentPage === totalPages"
      @click="changePage(currentPage + 1)"
      class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50"
    >
      ›
    </button>
  </div>
</template>

<script setup>
const props = defineProps({
  currentPage: Number,
  totalPages: Number
})
const emit = defineEmits(['page-change'])

function changePage(page) {
  emit('page-change', page)
}
</script>
