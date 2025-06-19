<template>
  <Card>
    <div>
      <div class="flex flex-row md:flex-nowrap gap-x-6">
        <!-- Kiri: Detail Pasien -->
        <div class="flex-1">
          <div class="flex flex-wrap gap-y-5 gap-x-6">
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Nama</p>
              <p class="text-base">{{ pasien.nama }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Umur</p>
              <p class="text-base">{{ pasien.umur }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Jenis Kelamin</p>
              <p class="text-base">{{ pasien.jenis_kelamin }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">NIK</p>
              <p class="text-base">{{ pasien.nik }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Alamat</p>
              <p class="text-base">{{ pasien.alamat }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Telepon</p>
              <p class="text-base">{{ pasien.no_telepon }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Jenis Pasien</p>
              <p class="text-base">{{ pasien.jenis_pasien }}</p>
            </div>
            <div v-if="pasien.berlaku_hingga" class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Berlaku Hingga</p>
              <p class="text-base">{{ pasien.berlaku_hingga }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Poli Asal</p>
              <p class="text-base">{{ pasien.poli_asal }}</p>
            </div>
            <div class="flex flex-col gap-y-2">
              <p class="uppercase text-[#969696] text-sm font-light">Riwayat</p>
              <p class="text-base">{{ pasien.riwayat_medis }}</p>
            </div>
          </div>
        </div>

        <!-- Kanan: Aksi -->
        <div class="w-fit flex flex-col gap-2 items-end">
          <PrimaryButton color="orange" @click="editPasien">Edit
            <template #icon>
              <ArrowRightStartOnRectangleIcon class="size-5" />
            </template>
          </PrimaryButton>
          <PrimaryButton color="red" @click="hapusPasien">Hapus
            <template #icon>
              <ArrowRightStartOnRectangleIcon class="size-5" />
            </template>
          </PrimaryButton>
          <!-- Dropdown Tambah Jadwal -->
          <div class="relative ">
            <button
              class="bg-[#ADDC8B] w-full text-sm text-white px-4 py-1 rounded-full flex items-center justify-between gap-2"
              @click="dropdownOpen = !dropdownOpen">
              Tambah Jadwal
              <ArrowRightStartOnRectangleIcon class="size-5" />
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
    </div>

    <!-- Tabel Jadwal -->
    <template #table>
      <div v-if="sortedJadwal.length === 0">
        <p>Belum ada jadwal.</p>
      </div>
      <div v-else>
        <Tabel :headers="['Hari', 'Tanggal', 'Pukul', 'Jenis Terapi']"
          :keys="['hari', 'tanggal_terapi', 'waktu', 'jenis_terapi']" :items="sortedJadwal" :actions="[
            { label: 'Edit', event: 'edit', name: 'edit' },
            { label: 'Hapus', event: 'hapus', name: 'hapus' }
          ]" @edit="editJadwal" @hapus="hapusJadwal" />
      </div>
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
import { ArrowRightStartOnRectangleIcon } from '@heroicons/vue/24/outline'

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

const sortedJadwal = computed(() => {
  const formatterHari = new Intl.DateTimeFormat('id-ID', { weekday: 'long' })
  const formatterTanggal = new Intl.DateTimeFormat('id-ID', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })

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
</script>
