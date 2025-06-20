<template>
        <div class="flex justify-center items-center gap-x-3 my-4">
            <button @click="$emit('prev-month')" class="px-3 py-1 bg-gray-100 rounded"><</button>
            <div class="font-semibold text-lg">{{ namaBulan(bulan) }} {{ tahun }}</div>
            <button @click="$emit('next-month')" class="px-3 py-1 bg-gray-100 rounded">></button>
        </div>

        <!-- Hari -->
        <div class="grid grid-cols-7 border-y border-gray-200 text-start text-base font-semibold divide-gray-200 text-gray-700 divide-x">
            <div v-for="hari in hariList" :key="hari" class="pl-4 py-1 font-thin text-sm uppercase text-orange">{{ hari }}</div>
        </div>

        <!-- Kalender -->
        <div class="grid grid-cols-7 gap-px divide-x divide-y divide-gray-200  overflow-hidden">
            <div v-for="n in firstDayOfMonth" :key="'empty-' + n" class="aspect-square bg-white"></div>

            <div v-for="item in daysInMonth" :key="item.tanggal"
                class="aspect-square bg-white px-4 py-4 flex flex-col justify-between cursor-pointer" :class="{
                    'text-gray-400 pointer-events-none': isPast(item.tanggal),
                    'hover:bg-green-50 transition duration-200': !item.penuh && !isPast(item.tanggal),
                    'hover:bg-red-50 transition duration-200': item.penuh && !isPast(item.tanggal)
                }" @click="!item.penuh && !isPast(item.tanggal) && $emit('pilih-tanggal', item.tanggal)">
                <!-- Tanggal -->
                <div class="text-2xl font-semibold">{{ new Date(item.tanggal).getDate() }}</div>
                <!-- Label Status -->
                <div class="text-base font-thin px-2 py-0.5 rounded self-start" :class="{
                    'bg-green-100 text-green-500': !item.penuh && !isPast(item.tanggal),
                    'bg-red-100 text-red-500': item.penuh && !isPast(item.tanggal),
                    'bg-gray-100 text-gray-400': isPast(item.tanggal)
                }">
                    {{ item.penuh ? 'Penuh' : 'Tersedia' }}
                </div>
            </div>
        </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    tahun: Number,
    bulan: Number,
    jenisTerapi: String,
    tanggalList: Array
})

const hariList = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']

const namaBulan = (index) => {
    return [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ][index]
}

const firstDayOfMonth = computed(() => {
    const firstDate = new Date(props.tahun, props.bulan, 1)
    return firstDate.getDay()
})

const daysInMonth = computed(() => {
    const lastDate = new Date(props.tahun, props.bulan + 1, 0).getDate()
    const items = []
    for (let d = 1; d <= lastDate; d++) {
        const tanggal = `${props.tahun}-${String(props.bulan + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`
        const data = props.tanggalList.find(t => t.tanggal === tanggal)
        items.push({
            tanggal,
            penuh: data?.penuh ?? false
        })
    }
    return items
})

const isPast = (tanggalStr) => {
    const todayStr = new Date().toISOString().split('T')[0]
    return tanggalStr < todayStr
}
</script>
