<template>
  <div>
    <h1>Manajemen Pasien: {{ pasien.nama }}</h1>
    <div class="detail-pasien">
      <p><strong>Umur:</strong> {{ pasien.umur }}</p>
      <p><strong>Jenis Kelamin:</strong> {{ pasien.jenis_kelamin }}</p>
      <p><strong>NIK:</strong> {{ pasien.nik }}</p>
      <p><strong>Alamat:</strong> {{ pasien.alamat }}</p>
      <p><strong>Telepon:</strong> {{ pasien.no_telepon }}</p>
      <p><strong>Jenis Pasien:</strong> {{ pasien.jenis_pasien }}</p>
      <p v-if="pasien.berlaku_hingga"><strong>Berlaku Hingga:</strong> {{ pasien.berlaku_hingga }}</p>
      <p><strong>Poli Asal:</strong> {{ pasien.poli_asal }}</p>
      <p><strong>Riwayat:</strong> {{ pasien.riwayat_medis }}</p>
      <button @click="editPasien">Edit</button>
      <button @click="hapusPasien">Hapus</button>
    </div>

    <h2>Jadwal Terapi</h2>
    <div v-if="jadwalList.length === 0">
      <p>Belum ada jadwal.</p>
      <button @click="tambahJadwal">Tambah Jadwal</button>
    </div>
    <table v-else border="1" cellpadding="8">
      <button @click="tambahJadwal">Tambah Jadwal</button>
      <tr>
        <th>Jenis Terapi</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
      <tr v-for="jadwal in jadwalList" :key="jadwal.id">
        <td>{{ jadwal.jenis_terapi }}</td>
        <td>{{ jadwal.tanggal_terapi }}</td>
        <td>
          <button @click="editJadwal(jadwal)">Edit</button>
          <button @click="hapusJadwal(jadwal.id)">Hapus</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { usePasienStore } from '@/stores/pasienStore'
import { useJadwalStore } from '@/stores/jadwalStore'

const route = useRoute()
const router = useRouter()

const pasienStore = usePasienStore()
const jadwalStore = useJadwalStore()

const id = route.params.id

onMounted(async () => {
  await pasienStore.getPasienById(id)
  await jadwalStore.fetchByPasien(id)
})

// buat pasien & jadwal reactive (computed agar re-render otomatis)
const pasien = computed(() => pasienStore.pasien)
const jadwalList = computed(() => jadwalStore.jadwalList)

const editPasien = () => {
  router.push({ name: 'EditPasien', params: { id: pasien.value.id } })
}

const hapusPasien = async () => {
  if (!confirm('Yakin hapus pasien?')) return
  await pasienStore.deletePasien(pasien.value.id)
  alert('Pasien dihapus')
  router.push({ name: 'DaftarPasien' })
}

const tambahJadwal = () => {
  router.push({ name: 'TambahEditJadwal', params: { pasienId: pasien.value.id } })
}

const editJadwal = (jadwal) => {
  router.push({ name: 'TambahEditJadwal', params: { pasienId: pasien.value.id, jadwalId: jadwal.id } })
}

const hapusJadwal = async (jadwalId) => {
  if (!confirm('Yakin hapus jadwal?')) return
  await jadwalStore.deleteJadwal(pasien.value.id, jadwalId)
}
</script>
