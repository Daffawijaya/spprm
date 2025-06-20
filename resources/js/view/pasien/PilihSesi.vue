<template>
  <div>
    <h2>Pilih Sesi - {{ tanggal }}</h2>
    <ul>
      <li v-for="sesi in statusList" :key="sesi.sesi">
        <button @click="pilihSesi(sesi.sesi)" :disabled="sesi.status === 'penuh'">
          Sesi {{ sesi.sesi }} -
          <strong>{{ sesi.status }} ({{ sesi.kuota }})</strong>
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import { useBulanStore } from '@/stores/bulanStore'
import { useJadwalStore } from '@/stores/jadwalStore'

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
