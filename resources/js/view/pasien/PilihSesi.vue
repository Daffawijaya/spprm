<template>
  <Card>
    <template #header>
      Pilih Sesi
    </template>

    <template #table>
      <Tabel :headers="['Hari', 'Tanggal', 'Waktu', 'Kuota']"
        :keys="['hari', 'tanggal', 'waktu', 'kuota']" :items="tabelData">
        <template #actions="{ item }">
          <PrimaryButton :color="item.status === 'penuh' ? 'gray' : 'green'" :block="false"
            class="disabled:bg-gray-300 disabled:cursor-not-allowed" :disabled="item.status === 'penuh'"
            @click="pilihSesi(item.sesi)">
            Pilih
          </PrimaryButton>
        </template>
      </Tabel>
    </template>

  </Card>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useBulanStore } from '@/stores/bulanStore'
import { useJadwalStore } from '@/stores/jadwalStore'
import Tabel from '@/components/Tabel.vue'
import PrimaryButton from '@/components/PrimaryButton.vue'
import Card from '@/components/Card.vue'

const router = useRouter()
const route = useRoute()
const { pasienId, jenisTerapi, tanggal } = route.params

const bulanStore = useBulanStore()
const jadwalStore = useJadwalStore()

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
    tanggal: formatTanggalIndo(sesi.tanggal),
    waktu: sesi.waktu,
    kuota: sesi.kuota,
    status: sesi.status
  }))
)

const pilihSesi = async (sesi) => {
  try {
    const response = await jadwalStore.createJadwal(pasienId, {
      jenis_terapi: jenisTerapi,
      tanggal_terapi: tanggal,
      sesi
    })

    if (response.success) {
      alert('Jadwal berhasil ditambahkan!')
      router.push({ name: 'ManajemenPasien', params: { id: pasienId } })
    } else {
      alert(response.message)
    }
  } catch (error) {
    const pesan = error.response?.data?.error || 'Terjadi kesalahan.'
    alert(pesan)
  }
}
</script>
