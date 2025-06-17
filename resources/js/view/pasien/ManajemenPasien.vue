<template>
  <div class="p-4 space-y-6">
    <h1 class="text-2xl font-bold">Manajemen Pasien: {{ pasien.nama }}</h1>

    <div class="bg-gray-100 p-4 rounded shadow">
      <p><strong>Umur:</strong> {{ pasien.umur }}</p>
      <p><strong>Jenis Kelamin:</strong> {{ pasien.jenis_kelamin }}</p>
      <p><strong>NIK:</strong> {{ pasien.nik }}</p>
      <p><strong>Alamat:</strong> {{ pasien.alamat }}</p>
      <p><strong>Telepon:</strong> {{ pasien.no_telepon }}</p>
      <p><strong>Jenis Pasien:</strong> {{ pasien.jenis_pasien }}</p>
      <p v-if="pasien.berlaku_hingga"><strong>Berlaku Hingga:</strong> {{ pasien.berlaku_hingga }}</p>
      <p><strong>Poli Asal:</strong> {{ pasien.poli_asal }}</p>
      <p><strong>Riwayat:</strong> {{ pasien.riwayat_medis }}</p>
      <div class="mt-4 flex gap-2">
        <button @click="editPasien" class="bg-blue-500 text-white px-4 py-1 rounded">Edit</button>
        <button @click="hapusPasien" class="bg-red-500 text-white px-4 py-1 rounded">Hapus</button>
      </div>
    </div>

    <h2 class="text-xl font-semibold">Jadwal Terapi</h2>

    <!-- Tombol & Dropdown -->
    <div class="relative inline-block">
      <button @click="dropdownOpen = !dropdownOpen" class="bg-green-500 text-white px-4 py-2 rounded">
        Tambah Jadwal
      </button>
      <div v-if="dropdownOpen" class="absolute mt-2 bg-white border shadow rounded z-10">
        <ul>
          <li
            v-for="jenis in jenisTerapiOptions"
            :key="jenis"
            @click="pilihJenisTerapi(jenis)"
            class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
          >
            {{ jenis }}
          </li>
        </ul>
      </div>
    </div>

    <div v-if="sortedJadwal.length === 0">
      <p>Belum ada jadwal.</p>
    </div>
    <table v-else class="table-auto border-collapse w-full border">
      <thead>
        <tr class="bg-gray-200">
          <th class="border px-4 py-2">Jenis Terapi</th>
          <th class="border px-4 py-2">Tanggal</th>
          <th class="border px-4 py-2">Sesi</th>
          <th class="border px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="jadwal in sortedJadwal" :key="jadwal.id">
          <td class="border px-4 py-2">{{ jadwal.jenis_terapi }}</td>
          <td class="border px-4 py-2">{{ jadwal.tanggal_terapi }}</td>
          <td class="border px-4 py-2">{{ jadwal.sesi }}</td>
          <td class="border px-4 py-2">
            <button @click="editJadwal(jadwal)" class="text-blue-600 hover:underline mr-2">Edit</button>
            <button @click="hapusJadwal(jadwal.id)" class="text-red-600 hover:underline">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, computed, ref } from 'vue'
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

const pasien = computed(() => pasienStore.pasien)
const jadwalList = computed(() => jadwalStore.jadwalList)

const sortedJadwal = computed(() => {
  return [...jadwalList.value].sort((a, b) => {
    return new Date(a.tanggal_terapi) - new Date(b.tanggal_terapi)
  })
})

const jenisTerapiOptions = [
  'Fisioterapi',
  'Fisioterapi Pediatri',
  'Okupasi Terapi',
  'Terapi Wicara',
  'Psikologis Klinis'
]

const dropdownOpen = ref(false)

const pilihJenisTerapi = (jenis) => {
  dropdownOpen.value = false
  router.push({
    name: 'PilihTanggal',
    params: {
      pasienId: pasien.value.id,
      jenisTerapi: jenis
    }
  })
}

const editPasien = () => {
  router.push({ name: 'EditPasien', params: { id: pasien.value.id } })
}

const hapusPasien = async () => {
  if (!confirm('Yakin hapus pasien?')) return
  await pasienStore.deletePasien(pasien.value.id)
  alert('Pasien dihapus')
  router.push({ name: 'DaftarPasien' })
}

const editJadwal = (jadwal) => {
  router.push({ name: 'TambahEditJadwal', params: { pasienId: pasien.value.id, jadwalId: jadwal.id } })
}

const hapusJadwal = async (jadwalId) => {
  if (!confirm('Yakin hapus jadwal?')) return
  await jadwalStore.deleteJadwal(pasien.value.id, jadwalId)
}
</script>
