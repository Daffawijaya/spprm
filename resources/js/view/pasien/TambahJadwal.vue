<template>
  <div class="container">
    <h1>Tambah Jadwal Terapi</h1>
    <form @submit.prevent="submitJadwal">
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
        {{ loading ? 'Menyimpan...' : 'Tambah Jadwal' }}
      </button>

      <p v-if="error" style="color:red">{{ error }}</p>
      <p v-if="success" style="color:green">{{ success }}</p>
    </form>
  </div>
</template>

<script>
import SesiDropdown from '../../components/SesiDropdown.vue'
import JenisTerapiDropdown from '../../components/JenisTerapiDropdown.vue'
import axios from 'axios'

export default {
  components: { SesiDropdown, JenisTerapiDropdown },
  props: {
    pasienId: { type: Number, required: true }
  },
  data() {
    return {
      form: {
        jenis_terapi: '',
        tanggal_terapi: '',
        sesi: ''
      },
      loading: false,
      error: '',
      success: ''
    }
  },
  methods: {
    async submitJadwal() {
      this.error = ''
      this.success = ''
      this.loading = true

      try {
        const response = await axios.post(`/api/pasien/${this.pasienId}/jadwal`, this.form)
        this.success = 'Jadwal berhasil ditambahkan!'
        this.form.jenis_terapi = ''
        this.form.tanggal_terapi = ''
        this.form.sesi = ''
      } catch (err) {
        this.error = err.response?.data?.message || 'Gagal menyimpan jadwal'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
