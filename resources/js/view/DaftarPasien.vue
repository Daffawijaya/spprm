<template>
  <div>
    <h1>Daftar Pasien</h1>
    <Tabel
      :headers="['Nama', 'Umur', 'Jenis Kelamin', 'Poli Asal']"
      :keys="['nama', 'umur', 'jenis_kelamin', 'poli_asal']"
      :items="pasienList"
      :actions="[{ name: 'detail', label: 'Detail', event: 'lihatDetail' }]"
      @lihatDetail="tampilkanDetail"
    />
  </div>
</template>

<script>
import axios from 'axios'
import Tabel from '../components/Tabel.vue'

export default {
  components: { Tabel },
  data() {
    return {
      pasienList: []
    }
  },
  mounted() {
    this.ambilPasien()
  },
  methods: {
    async ambilPasien() {
      try {
        const response = await axios.get('/api/pasien')
        this.pasienList = response.data
      } catch (error) {
        console.error('Gagal ambil data pasien:', error)
      }
    },
    tampilkanDetail(pasien) {
      alert(`Detail pasien: ${pasien.nama}, umur ${pasien.umur}`)
    }
  }
}
</script>