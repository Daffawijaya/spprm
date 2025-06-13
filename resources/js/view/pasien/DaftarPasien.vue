<template>
  <div>
    <h1>Daftar Pasien</h1>

    <div v-if="loading">Loading...</div>
    <div v-else>
      <Tabel
        :headers="['Nama', 'Umur', 'Jenis Kelamin', 'Poli Asal']"
        :keys="['nama', 'umur', 'jenis_kelamin', 'poli_asal']"
        :items="pasienStore.pasienList"
        :actions="[{ name: 'detail', label: 'Detail', event: 'detailClicked' }]"
        @detailClicked="goToManajemen"
      />
    </div>

    <div v-if="pasienStore.error" class="text-red-500">
      Terjadi kesalahan saat mengambil data.
    </div>
  </div>
</template>

<script>
import { usePasienStore } from '@/stores/pasienStore'
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Tabel from '../../components/Tabel.vue'

export default {
  components: { Tabel },
  setup() {
    const pasienStore = usePasienStore()
    const router = useRouter()

    onMounted(() => {
      pasienStore.fetchPasien()
    })

    const goToManajemen = (item) => {
      router.push({
        name: 'ManajemenPasien',
        params: { id: item.id }
      })
    }

    return {
      pasienStore,
      goToManajemen,
      loading: pasienStore.loading
    }
  }
}
</script>
