<template>
  <div>
    <h1>Edit Pasien</h1>
    <Form :form="form" :onSubmit="kirimData" />
  </div>
</template>

<script>
import Form from '../../components/Form.vue'
import { usePasienStore } from '../../stores/pasienStore' // ✅ Import store


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
        alert('Gagal memperbarui data pasien')
        console.error(err)
      }
    }
  }
}
</script>
