<template>
  <Card>
    <template #header>
      Tambah Pasien
    </template>
    <template #form>
      <Form :form="form" :onSubmit="kirimData" />
    </template>
  </Card>
</template>

<script>
import axios from 'axios'
import Form from '../components/Form.vue'
import Card from '../components/Card.vue'

export default {
  components: { Form, Card },
  data() {
    return {
      form: {
        nama: '',
        umur: '',
        jenis_kelamin: '',
        nik: '',
        alamat: '',
        no_telepon: '',
        jenis_pasien: '',
        berlaku_hingga: '',
        poli_asal: '',
        riwayat_medis: '',
      },
      errorMessage: ''
    }
  },
  methods: {
    async kirimData() {
      this.errorMessage = ''
      try {
        const dataKirim = { ...this.form }
        if (dataKirim.jenis_pasien !== 'BPJS') {
          delete dataKirim.berlaku_hingga
        }

        const res = await axios.post('/api/pasien', dataKirim)

        alert('Data pasien berhasil disimpan!')
        this.$router.push({ name: 'ManajemenPasien', params: { id: res.data.id } })
      } catch (err) {
        if (err.response && err.response.status === 422) {
          const errors = err.response.data.errors
          const firstError = Object.values(errors)[0][0]
          alert(firstError)
        } else {
          alert('Gagal menyimpan data.')
          this.errorMessage = 'Gagal menyimpan data.'
        }
        console.error(err)
      }
    },

    resetForm() {
      this.form = {
        nama: '',
        umur: '',
        jenis_kelamin: '',
        nik: '',
        alamat: '',
        no_telepon: '',
        jenis_pasien: '',
        berlaku_hingga: '',
        poli_asal: '',
        riwayat_medis: '',
      }
    }
  }
}
</script>
