<template>
  <div class="container">
    <h1>{{ isEdit ? 'Edit Jadwal Terapi' : 'Tambah Jadwal Terapi' }}</h1>
    <form @submit.prevent="submitForm">
      <div>
        <label>Jenis Terapi</label>
        <JenisTerapiDropdown v-model="form.jenis_terapi" />
      </div>

      <div>
        <label>Tanggal Terapi</label>
        <input type="date" v-model="form.tanggal_terapi" required />
      </div>

      <div>
        <label>Sesi Terapi</label>
        <SesiDropdown v-model="form.sesi" />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Menyimpan...' : isEdit ? 'Update Jadwal' : 'Tambah Jadwal' }}
      </button>

      <p v-if="error" style="color:red">{{ error }}</p>
      <p v-if="success" style="color:green">{{ success }}</p>
    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useJadwalStore } from '@/stores/jadwalStore'
import SesiDropdown from '@/components/SesiDropdown.vue'
import JenisTerapiDropdown from '@/components/JenisTerapiDropdown.vue'

const route = useRoute()
const router = useRouter()
const jadwalStore = useJadwalStore()

const pasienId = Number(route.params.pasienId)
const jadwalId = route.params.jadwalId ? Number(route.params.jadwalId) : null

const isEdit = ref(false)
const form = ref({
  jenis_terapi: '',
  tanggal_terapi: '',
  sesi: ''
})

const loading = ref(false)
const error = ref('')
const success = ref('')

onMounted(async () => {
  if (jadwalId) {
    isEdit.value = true
    loading.value = true
    try {
      const res = await jadwalStore.fetchByPasien(pasienId)
      const current = jadwalStore.jadwalList.find(j => j.id === jadwalId)
      if (current) {
        form.value = {
          jenis_terapi: current.jenis_terapi,
          tanggal_terapi: current.tanggal_terapi,
          sesi: current.sesi
        }
      } else {
        error.value = 'Data jadwal tidak ditemukan'
      }
    } catch (err) {
      error.value = 'Gagal mengambil data jadwal'
    } finally {
      loading.value = false
    }
  }
})

const submitForm = async () => {
  loading.value = true
  error.value = ''
  success.value = ''
  try {
    if (isEdit.value) {
      await jadwalStore.updateJadwal(pasienId, jadwalId, form.value)
      success.value = 'Jadwal berhasil diupdate!'
    } else {
      const result = await jadwalStore.createJadwal(pasienId, form.value)
      if (!result.success) {
        throw new Error(result.message)
      }
      success.value = 'Jadwal berhasil ditambahkan!'
      form.value = { jenis_terapi: '', tanggal_terapi: '', sesi: '' }
    }
    router.push({ name: 'ManajemenPasien', params: { id: pasienId } })
  } catch (err) {
    error.value = err.message || 'Gagal menyimpan jadwal'
  } finally {
    loading.value = false
  }
}
</script>
