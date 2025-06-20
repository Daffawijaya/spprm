<template>
  <Card>
    <template #header>
      <h1>Detail Pasien</h1>
    </template>
    <div class="flex flex-row md:flex-nowrap gap-x-6">
      <!-- Kiri: Detail Pasien -->
      <div class="flex-1">
        <InfoGrid :items="infoItems" />
      </div>



      <!-- Kanan: Aksi -->
      <div class="w-fit flex flex-col gap-2 items-end">
        <PrimaryButton color="orange" @click="editPasien">
          Edit
          <template #icon>
            <PencilIcon class="size-4" />
          </template>
        </PrimaryButton>

        <PrimaryButton color="red" @click="hapusPasien">
          Hapus
          <template #icon>
            <TrashIcon class="size-4" />
          </template>
        </PrimaryButton>

        <!-- Dropdown Tambah Jadwal -->
        <div class="relative ">
          <button
            class="bg-[#ADDC8B] w-full text-sm text-white px-4 py-1 rounded-full flex items-center justify-between gap-2"
            @click="dropdownOpen = !dropdownOpen">
            Tambah Jadwal
            <PlusIcon class="size-4" />
          </button>

          <div v-if="dropdownOpen" class="absolute mt-2 w-full bg-white border shadow rounded z-30">
            <ul>
              <li v-for="jenis in jenisTerapiOptions" :key="jenis" @click.stop="pilihJenisTerapi(jenis)"
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                {{ jenis }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabel Jadwal -->
    <template #table>
      <div v-if="sortedJadwal.length === 0">
        <p>Belum ada jadwal.</p>
      </div>
      <div v-else>
        <Tabel :headers="['Hari', 'Tanggal', 'Pukul', 'Jenis Terapi']"
          :keys="['hari', 'tanggal_terapi', 'waktu', 'jenis_terapi']" :items="sortedJadwal" @edit="editJadwal"
          @hapus="hapusJadwal">
          <template #actions="{ item, emit }">
            <div class="flex justify-center gap-2">
              <ActionButton :icon="PencilIcon" color="orange" @click="emit('edit', item)" />
              <ActionButton :icon="TrashIcon" color="red" @click="emit('hapus', item)" />
            </div>
          </template>
        </Tabel>
      </div>
    </template>
    <template #footer>
      <Pagination :currentPage="pagination.current_page" :totalPages="pagination.last_page" @page-change="changePage" />
    </template>

  </Card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { usePasienStore } from '@/stores/pasienStore'
import { useJadwalStore } from '@/stores/jadwalStore'
import Tabel from '@/components/Tabel.vue'
import Card from '@/components/Card.vue' // 🔸 Import Card
import PrimaryButton from '../../components/PrimaryButton.vue'
import ActionButton from '@/components/ActionButton.vue'
import { PencilIcon, TrashIcon, PlusIcon } from '@heroicons/vue/24/solid'
import Pagination from '../../components/Pagination.vue'
import InfoGrid from '@/components/InfoGrid.vue'

const route = useRoute()
const router = useRouter()

const pasienStore = usePasienStore()
const jadwalStore = useJadwalStore()

const id = route.params.id
const dropdownOpen = ref(false)

onMounted(async () => {
  await pasienStore.getPasienById(id)
  await jadwalStore.fetchByPasien(id)
})

const pasien = computed(() => pasienStore.pasien)
const jadwalList = computed(() => jadwalStore.jadwalList)
const pagination = computed(() => jadwalStore.pagination)


const sortedJadwal = computed(() => {
  const formatterHari = new Intl.DateTimeFormat('id-ID', { weekday: 'long' })
  const formatterTanggal = new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });

  return [...jadwalList.value]
    .sort((a, b) => new Date(a.tanggal_terapi) - new Date(b.tanggal_terapi))
    .map(jadwal => {
      const tanggalObj = new Date(jadwal.tanggal_terapi)
      return {
        ...jadwal,
        hari: formatterHari.format(tanggalObj),
        tanggal_terapi: formatterTanggal.format(tanggalObj)
      }
    })
})

const jenisTerapiOptions = [
  'Fisioterapi',
  'Fisioterapi Pediatri',
  'Okupasi Terapi',
  'Terapi Wicara',
  'Psikologis Klinis'
]

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
  router.push({
    name: 'TambahEditJadwal',
    params: { pasienId: pasien.value.id, jadwalId: jadwal.id }
  })
}

const hapusJadwal = async (jadwal) => {
  if (!confirm('Yakin hapus jadwal?')) return
  await jadwalStore.deleteJadwal(pasien.value.id, jadwal.id)
}

const currentPage = ref(1)

const changePage = async (page) => {
  currentPage.value = page
  await jadwalStore.fetchByPasien(pasien.value.id, page)
}

const infoItems = computed(() => {
  const tgl = pasien.value.berlaku_hingga
  const formatTanggal = (tglStr) => {
    if (!tglStr) return '-'
    const date = new Date(tglStr)
    return new Intl.DateTimeFormat('id-ID', {
      day: 'numeric',
      month: 'long',
      year: 'numeric'
    }).format(date)
  }

  const items = [
    { label: 'Nama', value: pasien.value.nama },
    { label: 'Umur', value: pasien.value.umur },
    { label: 'Jenis Kelamin', value: pasien.value.jenis_kelamin },
    { label: 'NIK', value: pasien.value.nik },
    { label: 'Alamat', value: pasien.value.alamat },
    { label: 'Telepon', value: pasien.value.no_telepon },
    { label: 'Jenis Pasien', value: pasien.value.jenis_pasien },
    { label: 'Poli Asal', value: pasien.value.poli_asal }
  ]

  if (pasien.value.berlaku_hingga) {
    items.push({ label: 'Berlaku Hingga', value: formatTanggal(tgl) })
  }

  if (pasien.value.riwayat_medis) {
    items.push({ label: 'Riwayat', value: pasien.value.riwayat_medis })
  }

  return items
})

</script>
