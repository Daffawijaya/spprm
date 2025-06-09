<template>
  <form @submit.prevent="handleSubmit">
    <div>
      <label>Nama:</label>
      <input type="text" v-model="form.nama" required />
    </div>
    <div>
      <label>Umur:</label>
      <input type="number" v-model="form.umur" required />
    </div>
    <div>
      <label>Jenis Kelamin:</label>
      <select v-model="form.jenis_kelamin" required>
        <option value="">--Pilih--</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
      </select>
    </div>
    <div>
      <label>NIK:</label>
      <input type="text" v-model="form.nik" required />
    </div>
    <div>
      <label>Alamat:</label>
      <input type="text" v-model="form.alamat" required />
    </div>
    <div>
      <label>No. Telepon:</label>
      <input type="text" v-model="form.no_telepon" required />
    </div>
    <div>
      <label>Jenis Pasien:</label>
      <select v-model="form.jenis_pasien" required>
        <option value="">--Pilih--</option>
        <option value="BPJS">BPJS</option>
        <option value="Mandiri">Mandiri</option>
      </select>
    </div>
    <div v-if="form.jenis_pasien === 'BPJS'">
      <label>Berlaku Hingga:</label>
      <input type="date" v-model="form.berlaku_hingga" required />
    </div>
    <div>
      <label>Poli Asal:</label>
      <select v-model="form.poli_asal" required>
        <option value="">--Pilih--</option>
        <option value="Anak">Anak</option>
        <option value="Gigi & Mulut">Gigi & Mulut</option>
        <option value="Geriatri">Geriatri</option>
        <option value="Jiwa">Jiwa</option>
        <option value="Jiwa">Kandungan</option>
        <option value="Kandungan">Orthopedi</option>
        <option value="Paru">Paru</option>
        <option value="Penyakit Dalam">Penyakit Dalam</option>
        <option value="Saraf">Saraf</option>
      </select>
    </div>
    <div>
      <label>Riwayat:</label>
      <textarea v-model="form.riwayat_medis"></textarea>
    </div>
    <button type="submit">Simpan</button>
  </form>
</template>

<script>
export default {
  props: {
    form: Object,
    onSubmit: Function
  },
  methods: {
    handleSubmit() {
      this.onSubmit()
    }
  }
}
</script>