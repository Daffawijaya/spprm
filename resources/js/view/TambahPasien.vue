<template>
  <div>
    <h1>Tambah Pasien</h1>
    <Form :form="form" :onSubmit="kirimData" />
  </div>
</template>

<script>
import axios from 'axios'
import Form from '../components/Form.vue'

export default {
  components: { Form },
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
      }
    }
  },
  methods: {
    async kirimData() {
  try {
    const dataKirim = { ...this.form }
    if (dataKirim.jenis_pasien !== 'BPJS') delete dataKirim.berlaku_hingga
    const res = await axios.post('/api/pasien', dataKirim)
    alert('Data pasien berhasil disimpan!')
    this.$router.push({ name: 'ManajemenPasien', params: { id: res.data.id } })
  } catch (err) {
    alert('Gagal simpan data')
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
        riwayat: '',
      }
    }
  }
}
</script>