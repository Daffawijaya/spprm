<template>
    <Card>
        <template #header>
            Daftar Pasien - Sesi {{ query.sesi }} ({{ formatTanggal(route.params.tanggal) }})
        </template>

        <template #default>
            <InfoGrid :items="infoItems" />
        </template>


        <template #table>
            <Tabel :headers="['Nama', 'Umur', 'Jenis Terapi', 'Poli Asal']"
                :keys="['nama', 'umur', 'jenis_terapi', 'poli_asal']" :items="tabelData">
                <template #actions="{ item }">
                    <PrimaryButton color="green" @click="goToDetail(item.id)">
                        Detail
                    </PrimaryButton>
                </template>
            </Tabel>

            <p v-if="pasienStore.loading" class="mt-4 text-gray-500">Memuat data pasien...</p>
            <p v-if="!pasienStore.loading && tabelData.length === 0" class="py-20 flex items-center justify-center">
                Tidak ada pasien di sesi ini.
            </p>
        </template>
    </Card>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { usePasienStore } from '@/stores/pasienStore'
import Tabel from '@/components/Tabel.vue'
import PrimaryButton from '@/components/PrimaryButton.vue'
import Card from '@/components/Card.vue'
import InfoGrid from '@/components/InfoGrid.vue'

const route = useRoute()
const router = useRouter()
const query = route.query

const pasienStore = usePasienStore()

const formatTanggalIndoPendek = (tglStr) => {
    if (!tglStr) return '-'
    const date = new Date(tglStr)
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(date)
}

const formatTanggal = (tgl) =>
    new Date(tgl).toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })

onMounted(() => {
    if (route.params.tanggal && query.sesi) {
        pasienStore.fetchPasienByTanggalSesi(route.params.tanggal, query.sesi)
    }
})

const tabelData = computed(() => {
    return pasienStore.pasienResponse.pasien?.map(p => ({
        id: p.id,
        nama: p.nama,
        umur: p.umur,
        jenis_terapi: pasienStore.pasienResponse.jadwal?.jenis_terapi || '-',
        poli_asal: p.poli_asal
    })) || []
})

const infoItems = computed(() => [
    { label: 'Hari', value: pasienStore.pasienResponse.jadwal?.hari },
    { label: 'Tanggal', value: formatTanggalIndoPendek(pasienStore.pasienResponse.jadwal?.tanggal) },
    { label: 'Pukul', value: pasienStore.pasienResponse.jadwal?.waktu }
])

const goToDetail = (id) => {
    router.push({ name: 'ManajemenPasien', params: { id } })
}
</script>
