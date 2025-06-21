<template>
  <Card>
    <template #header>
      Edit Pasien
    </template>
    <template #form>
      <Form :form="form" :onSubmit="kirimData" />
    </template>
  </Card>
</template>

<script>
import Form from '../../components/Form.vue'
import Card from '../../components/Card.vue'
import { usePasienStore } from '../../stores/pasienStore' // ✅ Import store


export default {
  components: { Form, Card },
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
    const pasienStore = usePasienStore()
    const data = await pasienStore.getPasienById(this.id)
    if (data) {
      this.form = {
        nama: data.nama,
        umur: data.umur,
        jenis_kelamin: data.jenis_kelamin,
        nik: data.nik,
        alamat: data.alamat,
        no_telepon: data.no_telepon,
        jenis_pasien: data.jenis_pasien,
        berlaku_hingga: data.berlaku_hingga,
        poli_asal: data.poli_asal,
        riwayat_medis: data.riwayat_medis,
      }
    } else {
      alert('Gagal mengambil data pasien')
    }
  },
  methods: {
    async kirimData() {
      const pasienStore = usePasienStore()
      try {
        const dataKirim = { ...this.form }
        if (dataKirim.jenis_pasien !== 'BPJS') delete dataKirim.berlaku_hingga
        await pasienStore.updatePasien(this.id, dataKirim)
        alert('Data pasien berhasil diperbarui!')
        this.$router.push({ name: 'ManajemenPasien', params: { id: this.id } })
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
    }
  }
}
</script>
