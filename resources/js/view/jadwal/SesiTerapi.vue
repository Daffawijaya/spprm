<template>
    <div>
        <h2 class="text-xl font-semibold mb-4">Pilih Sesi</h2>

        <Tabel :headers="['Hari', 'Tanggal', 'Waktu', 'Kuota']" :keys="['hari', 'tanggal', 'waktu', 'kuota']"
            :items="tabelData">
            <template #actions="{ item }">
                <PrimaryButton :color="item.status === 'penuh' ? 'gray' : 'green'" :block="false"
                    class="disabled:bg-gray-300 disabled:cursor-not-allowed" :disabled="item.status === 'penuh'"
                    @click="pilihSesi(item.sesi)">
                    Pilih
                </PrimaryButton>
            </template>

        </Tabel>
    </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useBulanStore } from '@/stores/bulanStore'
import Tabel from '@/components/Tabel.vue'
import PrimaryButton from '../../components/PrimaryButton.vue'

const router = useRouter()
const route = useRoute()
const { pasienId, jenisTerapi, tanggal } = route.params

const bulanStore = useBulanStore()

onMounted(async () => {
    bulanStore.setJenisTerapi(jenisTerapi)
    await bulanStore.fetchStatusTanggal(tanggal)
})

const statusList = computed(() => bulanStore.statusSesi)

const formatTanggalIndo = (tanggalStr) => {
    const options = { day: 'numeric', month: 'long', year: 'numeric' }
    return new Date(tanggalStr).toLocaleDateString('id-ID', options)
}

const tabelData = computed(() =>
    statusList.value.map(sesi => ({
        sesi: sesi.sesi,
        hari: sesi.hari,
        tanggal: formatTanggalIndo(sesi.tanggal), // ⬅️ ubah format di sini
        waktu: sesi.waktu,
        kuota: sesi.kuota,
        status: sesi.status
    }))
)

const pilihSesi = (sesi) => {
    router.push({
        name: 'PasienBySesi',
        query: {
            tanggal,
            sesi
        }
    })
}
</script>
