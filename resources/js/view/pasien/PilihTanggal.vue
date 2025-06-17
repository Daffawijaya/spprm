<template>
  <div class="p-4">
    <h2 class="text-xl font-bold mb-4">Pilih Tanggal untuk {{ jenisTerapi }}</h2>

    <div class="flex justify-between items-center mb-4">
      <button @click="prevMonth" class="px-3 py-1 bg-gray-200 rounded">←</button>
      <div class="font-semibold text-lg">{{ namaBulan(bulan) }} {{ tahun }}</div>
      <button @click="nextMonth" class="px-3 py-1 bg-gray-200 rounded">→</button>
    </div>

    <!-- Header Hari -->
    <div class="grid grid-cols-7 text-center font-semibold mb-2">
      <div v-for="hari in hariList" :key="hari" class="text-sm">{{ hari }}</div>
    </div>

    <!-- Kalender -->
    <div class="grid grid-cols-7 gap-1">
      <div 
        v-for="n in firstDayOfMonth" 
        :key="'empty-' + n"
        class="h-20"
      ></div>

      <div
        v-for="item in daysInMonth"
        :key="item.tanggal"
        class="h-20 p-1 border rounded flex flex-col items-center justify-between cursor-pointer text-sm"
        :class="{
          'bg-gray-200 text-gray-500 cursor-not-allowed': isPast(item.tanggal),
          'bg-red-200 text-red-800': item.penuh && !isPast(item.tanggal),
          'bg-green-200 text-green-800': !item.penuh && !isPast(item.tanggal)
        }"
        @click="!item.penuh && !isPast(item.tanggal) && pilihTanggal(item.tanggal)"
      >
        <div>{{ new Date(item.tanggal).getDate() }}</div>
        <div class="text-xs">{{ item.penuh ? 'Penuh' : 'Tersedia' }}</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useBulanStore } from '@/stores/bulanStore'

const router = useRouter()
const route = useRoute()
const { pasienId, jenisTerapi } = route.params

const bulanStore = useBulanStore()
bulanStore.setJenisTerapi(jenisTerapi)

const today = new Date()
const tahun = ref(today.getFullYear())
const bulan = ref(today.getMonth()) // 0-indexed

const hariList = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']

const namaBulan = (index) => {
  return [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ][index]
}

const fetchTanggal = async () => {
  await bulanStore.fetchTanggalList(tahun.value, bulan.value + 1)
}

onMounted(fetchTanggal)

const firstDayOfMonth = computed(() => {
  const firstDate = new Date(tahun.value, bulan.value, 1)
  return firstDate.getDay()
})

const daysInMonth = computed(() => {
  const lastDate = new Date(tahun.value, bulan.value + 1, 0).getDate()
  const items = []
  for (let d = 1; d <= lastDate; d++) {
    const tanggal = `${tahun.value}-${String(bulan.value + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`
    const data = bulanStore.tanggalList.find(t => t.tanggal === tanggal)
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

const pilihTanggal = (tanggal) => {
  router.push({
    name: 'PilihSesi',
    params: { pasienId, jenisTerapi, tanggal }
  })
}

const nextMonth = () => {
  if (bulan.value === 11) {
    bulan.value = 0
    tahun.value++
  } else {
    bulan.value++
  }
  fetchTanggal()
}

const prevMonth = () => {
  if (bulan.value === 0) {
    bulan.value = 11
    tahun.value--
  } else {
    bulan.value--
  }
  fetchTanggal()
}
</script>
