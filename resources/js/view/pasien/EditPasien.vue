<template>
  <div>
    <h1>Edit Pasien</h1>
    <Form :form="form" :onSubmit="kirimData" />
  </div>
</template>

<script>
import axios from 'axios'
import Form from '../../components/Form.vue'

export default {
  components: { Form },
  props: ['id'],
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
  async created() {
    try {
      const res = await axios.get(`/api/pasien/${this.id}`)
      this.form = {
        nama: res.data.nama,
        umur: res.data.umur,
        jenis_kelamin: res.data.jenis_kelamin,
        nik: res.data.nik,
        alamat: res.data.alamat,
        no_telepon: res.data.no_telepon,
        jenis_pasien: res.data.jenis_pasien,
        berlaku_hingga: res.data.berlaku_hingga,
        poli_asal: res.data.poli_asal,
        riwayat_medis: res.data.riwayat_medis,
      }
    } catch (err) {
      alert('Gagal mengambil data pasien')
      console.error(err)
    }
  },
  methods: {
    async kirimData() {
      try {
        const dataKirim = { ...this.form }
        if (dataKirim.jenis_pasien !== 'BPJS') delete dataKirim.berlaku_hingga
        await axios.put(`/api/pasien/${this.id}`, dataKirim)
        alert('Data pasien berhasil diperbarui!')
        this.$router.push({ name: 'ManajemenPasien', params: { id: this.id } })
      } catch (err) {
        alert('Gagal memperbarui data pasien')
        console.error(err)
      }
    }
  }
}
</script>
