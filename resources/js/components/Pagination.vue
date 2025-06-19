<template>
    <div class="flex items-center justify-end gap-1 mt-4 text-sm">
        <!-- Tombol prev -->
        <button :disabled="currentPage === 1" @click="changePage(currentPage - 1)"
            class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50">
            &lt;
        </button>

        <!-- Tombol halaman -->
        <button v-for="page in paginationRange" :key="page" @click="changePage(page)"
            class="px-3 py-1 rounded text-sm" :class="{
                'bg-[#FF7D3F] text-white': page === currentPage,
                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100': page !== currentPage,
                'pointer-events-none': page === '...'
            }" :disabled="page === '...'">
            {{ page }}
        </button>

        <!-- Tombol next -->
        <button :disabled="currentPage === totalPages" @click="changePage(currentPage + 1)"
            class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50">
            &gt;
        </button>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    currentPage: Number,
    totalPages: Number
})
const emit = defineEmits(['page-change'])

function changePage(page) {
    if (page !== '...') {
        emit('page-change', page)
    }
}

// Logika membuat range pagination dengan ellipsis (...)
const paginationRange = computed(() => {
    const total = props.totalPages
    const current = props.currentPage
    const delta = 2
    const range = []
    const rangeWithDots = []
    let l

    for (let i = 1; i <= total; i++) {
        if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) {
            range.push(i)
        }
    }

    for (let i of range) {
        if (l) {
            if (i - l === 2) {
                rangeWithDots.push(l + 1)
            } else if (i - l > 2) {
                rangeWithDots.push('...')
            }
        }
        rangeWithDots.push(i)
        l = i
    }

    return rangeWithDots
})
</script>
