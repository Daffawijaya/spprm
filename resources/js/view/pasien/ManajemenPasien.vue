<template>
  <div>
    <h1>Manajemen Pasien: {{ pasien.nama }}</h1>
    <div class="detail-pasien">
      <p><strong>Umur:</strong> {{ pasien.umur }}</p>
      <p><strong>Jenis Kelamin:</strong> {{ pasien.jenis_kelamin }}</p>
      <p><strong>NIK:</strong> {{ pasien.nik }}</p>
      <p><strong>Alamat:</strong> {{ pasien.alamat }}</p>
      <p><strong>Telepon:</strong> {{ pasien.nomor_telepon }}</p>
      <p><strong>Jenis Pasien:</strong> {{ pasien.jenis_pasien }}</p>
      <p v-if="pasien.berlaku_hingga"><strong>Berlaku Hingga:</strong> {{ pasien.berlaku_hingga }}</p>
      <p><strong>Poli Asal:</strong> {{ pasien.poli_asal }}</p>
      <p><strong>Riwayat:</strong> {{ pasien.riwayat }}</p>
      <button @click="editPasien">Edit</button>
      <button @click="hapusPasien">Hapus</button>
    </div>

    <h2>Jadwal Terapi</h2>
    <div v-if="jadwalList.length === 0">
      <p>Belum ada jadwal.</p>
      <button @click="tambahJadwal">Tambah Jadwal</button>
    </div>
    <table v-else border="1" cellpadding="8">
      <button @click="tambahJadwal">Tambah Jadwal</button>
      <tr>
        <th>Jenis Terapi</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
      <tr v-for="jadwal in jadwalList" :key="jadwal.id">
        <td>{{ jadwal.jenis_terapi }}</td>
        <td>{{ jadwal.tanggal_terapi }}</td>
        <td>
          <button @click="editJadwal(jadwal)">Edit</button>
          <button @click="hapusJadwal(jadwal.id)">Hapus</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      pasien: {},
      jadwalList: []
    }
  },
  async created() {
    const id = this.$route.params.id
    // Ambil detail pasien + jadwal (API sudah eager load jadwal)
    const res = await axios.get(`/api/pasien/${id}`)
    this.pasien = res.data
    this.jadwalList = res.data.jadwal_terapis || []
  },
  methods: {
    editPasien() {
      this.$router.push({ name: 'EditPasien', params: { id: this.pasien.id } })
    },
    async hapusPasien() {
      if (!confirm('Yakin hapus pasien?')) return
      await axios.delete(`/api/pasien/${this.pasien.id}`)
      alert('Pasien dihapus')
      this.$router.push({ name: 'DaftarPasien' })
    },
    tambahJadwal() {
      this.$router.push({ name: 'TambahJadwal', params: { pasienId: this.pasien.id } })
    },
    editJadwal(jadwal) {
      this.$router.push({ name: 'EditJadwal', params: { pasienId: this.pasien.id, jadwalId: jadwal.id } })
    },
    async hapusJadwal(id) {
      if (!confirm('Yakin hapus jadwal?')) return
      await axios.delete(`/api/pasien/${this.pasien.id}/jadwal/${id}`)
      this.jadwalList = this.jadwalList.filter(j => j.id !== id)
    }
  }
}
</script>
