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
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()
const { pasienId, jenisTerapi, tanggal } = route.params

const statusList = ref([])

const fetchStatus = async () => {
  const res = await axios.get('/api/status/tanggal', {
    params: {
      tanggal,
      jenis_terapi: jenisTerapi
    }
  })
  statusList.value = res.data.sesi
}

onMounted(fetchStatus)

const pilihSesi = async (sesi) => {
  try {
    await axios.post(`/api/pasien/${pasienId}/jadwal`, {
      jenis_terapi: jenisTerapi,
      tanggal_terapi: tanggal,
      sesi
    })

    alert('Jadwal berhasil ditambahkan!')
    router.push({ name: 'ManajemenPasien', params: { id: pasienId } })
  } catch (error) {
    const pesan = error.response?.data?.error || 'Terjadi kesalahan.'
    alert(pesan)
  }
}
</script>
