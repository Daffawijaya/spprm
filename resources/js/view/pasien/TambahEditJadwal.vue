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

<script>
import SesiDropdown from '../../components/SesiDropdown.vue'
import JenisTerapiDropdown from '../../components/JenisTerapiDropdown.vue'
import axios from 'axios'

export default {
  components: { SesiDropdown, JenisTerapiDropdown },
  props: {
    pasienId: { type: Number, required: true },
    jadwalId: { type: Number, default: null }
  },
  data() {
    return {
      isEdit: false,
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
  created() {
    if (this.jadwalId) {
      this.isEdit = true
      this.fetchJadwal()
    }
  },
  methods: {
          async fetchJadwal() {
      try {
        const res = await axios.get(`/api/pasien/${this.pasienId}/jadwal/${this.jadwalId}`)
        this.form = {
          jenis_terapi: res.data.jenis_terapi,
          tanggal_terapi: res.data.tanggal_terapi,
          sesi: res.data.sesi
        }
      } catch (err) {
        this.error = 'Gagal mengambil data jadwal'
      }
    },
    async submitForm() {
      this.error = ''
      this.success = ''
      this.loading = true

      try {
        if (this.isEdit) {
          await axios.put(`/api/pasien/${this.pasienId}/jadwal/${this.jadwalId}`, this.form)
          this.success = 'Jadwal berhasil diupdate!'
        } else {
          await axios.post(`/api/pasien/${this.pasienId}/jadwal`, this.form)
          this.success = 'Jadwal berhasil ditambahkan!'
          this.form = { jenis_terapi: '', tanggal_terapi: '', sesi: '' }
        }
        this.$router.push(`/daftar-pasien/manajemen/${this.pasienId}`)
      } catch (err) {
        this.error = err.response?.data?.message || 'Gagal menyimpan jadwal'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>