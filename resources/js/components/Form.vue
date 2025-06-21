<template>
  <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
    <!-- Nama -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Nama:</label>
      <input type="text" v-model="form.nama" required placeholder="Masukkan nama pasien"
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 placeholder-[#CCCCCC] focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]" />
    </div>

    <!-- Umur -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Umur:</label>
      <input type="number" v-model="form.umur" required placeholder="Masukkan umur"
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 placeholder-[#CCCCCC] focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]" />
    </div>

    <!-- Jenis Kelamin -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin:</label>
      <select v-model="form.jenis_kelamin" required
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]">
        <option value="">Pilih jenis kelamin</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
      </select>
    </div>

    <!-- NIK -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">NIK:</label>
      <input type="text" v-model="form.nik" required placeholder="Masukkan NIK"
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 placeholder-[#CCCCCC] focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]" />
    </div>

    <!-- Alamat -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat:</label>
      <input type="text" v-model="form.alamat" required placeholder="Masukkan alamat"
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 placeholder-[#CCCCCC] focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]" />
    </div>

    <!-- No. Telepon -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon:</label>
      <input type="text" v-model="form.no_telepon" required placeholder="Masukkan nomor telepon"
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 placeholder-[#CCCCCC] focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]" />
    </div>

    <!-- Jenis Pasien -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Pasien:</label>
      <select v-model="form.jenis_pasien" required
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-9 py-2 focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]">
        <option value="">Pilih jenis pasien</option>
        <option value="BPJS">BPJS</option>
        <option value="Mandiri">Mandiri</option>
      </select>
    </div>

    <!-- Berlaku Hingga -->
    <div v-if="form.jenis_pasien === 'BPJS'">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Berlaku Hingga:</label>
      <input type="date" v-model="form.berlaku_hingga" required
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]" />
    </div>

    <!-- Poli Asal -->
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Poli Asal:</label>
      <select v-model="form.poli_asal" required
        class="w-full rounded-full bg-[#F3F5FD] text-gray-800 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]">
        <option value="">Pilih poli asal</option>
        <option value="Anak">Anak</option>
        <option value="Gigi & Mulut">Gigi & Mulut</option>
        <option value="Geriatri">Geriatri</option>
        <option value="Jiwa">Jiwa</option>
        <option value="Kandungan">Kandungan</option>
        <option value="Orthopedi">Orthopedi</option>
        <option value="Paru">Paru</option>
        <option value="Penyakit Dalam">Penyakit Dalam</option>
        <option value="Saraf">Saraf</option>
      </select>
    </div>

    <!-- Riwayat -->
    <div class="md:col-span-2">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Riwayat:</label>
      <textarea v-model="form.riwayat_medis" rows="3" placeholder="Isi riwayat medis pasien jika ada"
        class="w-full rounded-md bg-[#F3F5FD] text-gray-800 px-4 py-2 placeholder-[#CCCCCC] focus:outline-none focus:ring-2 focus:ring-[#ADDC8B]"></textarea>
    </div>

    <!-- Tombol Simpan -->
    <div class="md:col-span-2 flex justify-end">
      <PrimaryButton color="green" @click="handleSubmit">
        Simpan
      </PrimaryButton>
    </div>
  </form>
</template>

<script setup>
import PrimaryButton from '@/components/PrimaryButton.vue'

const props = defineProps({
  form: Object,
  onSubmit: Function
})

const handleSubmit = () => {
  props.onSubmit()
}
</script>
