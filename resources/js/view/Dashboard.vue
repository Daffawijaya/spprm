<!-- views/Dashboard.vue -->
<template>
    <div class="space-y-2">
         <div class="text-xl font-semibold">
           Dashboard
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pb-2">
            <WidgetCard title="Total Pasien" :value="summary.total_pasien" valueLabel="Pasien" :icon="UserGroupIcon"
                bgColor="bg-orange" buttonColor="orange" buttonText="Daftar Pasien" @action="goToPasien" />

            <WidgetCard title="Total Jadwal" :value="summary.total_jadwal" valueLabel="Jadwal" :icon="CalendarDaysIcon"
                bgColor="bg-yellow" buttonColor="yellow" buttonText="Jadwal Terapi" @action="goToJadwal" />

        </div>
        <Card>

            <template #header>
                Jadwal Terapi
            </template>

            <template #table>
                <TanggalKalender :tahun="tahun" :bulan="bulan" :tanggalList="bulanStore.tanggalList"
                    @pilih-tanggal="pilihTanggal" @next-month="nextMonth" @prev-month="prevMonth" />
            </template>
        </Card>
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue'
import WidgetCard from '@/components/WidgetCard.vue'
import { UserGroupIcon, CalendarDaysIcon } from '@heroicons/vue/24/solid'
import axios from 'axios'
import Card from '../components/Card.vue'

import TanggalKalender from '@/components/TanggalKalender.vue'
import { useRouter, useRoute } from 'vue-router'
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
        name: 'SesiTerapi',
        params: { tanggal }
    })
}

const summary = ref({ total_pasien: 0, total_jadwal: 0 })

const fetchSummary = async () => {
    const res = await axios.get('/api/dashboard-summary')
    summary.value = res.data
}

onMounted(() => {
    fetchSummary()
})

function goToPasien() {
    router.push({ name: 'DaftarPasien' })
}

function goToJadwal() {
    router.push({ name: 'JadwalTerapi' })
}
</script>
