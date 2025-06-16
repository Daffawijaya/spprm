<template>
  <div>
    <h1>Daftar Pasien</h1>
    <Tabel
      :headers="['Nama', 'Umur', 'Jenis Kelamin', 'Poli Asal']"
      :keys="['nama', 'umur', 'jenis_kelamin', 'poli_asal']"
      :items="pasienStore.pasienList"
      :actions="[
        { name: 'detail', label: 'Detail', event: 'detailClicked' }
      ]"
      @detailClicked="goToManajemen"
    />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { usePasienStore } from '@/stores/pasienStore'
import Tabel from '@/components/Tabel.vue'

const router = useRouter()
const pasienStore = usePasienStore()

const goToManajemen = (item) => {
  router.push({ name: 'ManajemenPasien', params: { id: item.id } })
}

onMounted(() => {
  pasienStore.fetchPasien()
})
</script>
