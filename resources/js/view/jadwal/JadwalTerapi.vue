<template>
  <Card>
    
      <template #header>
        Jadwal Terapi
      </template>

      <template #table>
        <TanggalKalender :tahun="tahun" :bulan="bulan" :tanggalList="bulanStore.tanggalList"
          @pilih-tanggal="pilihTanggal" @next-month="nextMonth" @prev-month="prevMonth" />
      </template>
  </Card>
</template>

<script setup>
import Card from '@/components/Card.vue'
import TanggalKalender from '@/components/TanggalKalender.vue'
import { useRouter, useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import { useBulanStore } from '@/stores/bulanStore'

const router = useRouter()
const route = useRoute()
const { pasienId, jenisTerapi } = route.params

const bulanStore = useBulanStore()
bulanStore.setJenisTerapi(jenisTerapi)

const today = new Date()
const tahun = ref(today.getFullYear())
const bulan = ref(today.getMonth())

const fetchTanggal = async () => {
  await bulanStore.fetchTanggalList(tahun.value, bulan.value + 1)
}
onMounted(fetchTanggal)

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

const pilihTanggal = (tanggal) => {
  router.push({
    name: 'PilihSesi',
    params: { pasienId, jenisTerapi, tanggal }
  })
}
</script>
