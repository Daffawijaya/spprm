<template>
  <Card>
    <template #header>
      <h1>Daftar Pasien</h1>
    </template>

    <Search @search="handleSearch" />

    <!-- Pagination di slot table (atau bisa di slot footer juga) -->
    <template #table>
      <Tabel :headers="['Nama', 'Nik', 'Umur', 'Jenis Kelamin', 'Poli Asal']"
        :keys="['nama', 'nik', 'umur', 'jenis_kelamin', 'poli_asal']" :items="pasienStore.pasienList"
        :actions="[{ name: 'detail', label: 'Detail', event: 'detailClicked' }]" @detailClicked="goToManajemen">
        <template #actions="{ item, emit }">
          <div class="flex justify-center">
            <ActionButton :icon="EyeIcon" color="grey" @click="emit('detailClicked', item)" />
          </div>
        </template>
      </Tabel>
    </template>


    <template #footer>
      <Pagination :currentPage="pasienStore.pagination.currentPage" :totalPages="totalPages"
        @page-change="fetchByPage" />
    </template>

  </Card>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { usePasienStore } from '@/stores/pasienStore'
import Card from '@/components/Card.vue'
import Tabel from '@/components/Tabel.vue'
import Pagination from '@/components/Pagination.vue'
import Search from '../../components/Search.vue'
import ActionButton from '@/components/ActionButton.vue'
import { EyeIcon } from '@heroicons/vue/24/solid'

const router = useRouter()
const pasienStore = usePasienStore()

const goToManajemen = (item) => {
  router.push({ name: 'ManajemenPasien', params: { id: item.id } })
}

const totalPages = computed(() => {
  const total = pasienStore.pagination.total || 1
  const perPage = pasienStore.pagination.perPage || 10
  return Math.ceil(total / perPage)
})

function fetchByPage(page) {
  pasienStore.fetchPasien({ page })
}

function handleSearch(query) {
  pasienStore.fetchPasien({ search: query, page: 1 })
}


onMounted(() => {
  pasienStore.fetchPasien()
})
</script>
