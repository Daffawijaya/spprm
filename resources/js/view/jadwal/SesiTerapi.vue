<template>
  <div>
    <h2>Pilih Sesi - {{ tanggal }}</h2>
    <ul>
      <li v-for="sesi in statusList" :key="sesi.sesi">
        <button @click="pilihSesi(sesi.sesi)" :disabled="sesi.status === 'penuh'">
          Sesi {{ sesi.sesi }} - <strong>{{ sesi.status }} ({{ sesi.kuota }})</strong>
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useBulanStore } from '@/stores/bulanStore'

const route = useRoute()
const { tanggal } = route.params

const bulanStore = useBulanStore()

onMounted(async () => {
  // Tidak perlu setJenisTerapi jika hanya ingin lihat sesi
  await bulanStore.fetchStatusTanggal(tanggal)
})

const statusList = computed(() => bulanStore.statusSesi)

</script>
