<template>
  <select v-model="selectedValue" required>
    <option disabled value="">Pilih jenis terapi</option>
    <option v-for="jenis in jenisOptions" :key="jenis" :value="jenis">{{ jenis }}</option>
  </select>
</template>

<script>
export default {
  props: ['modelValue'],
  emits: ['update:modelValue'],
  data() {
    return {
      jenisOptions: [
        'Fisioterapi',
        'Fisioterapi Pediatri',
        'Psikologis Klinis',
        'Okupasi Terapi ',
        'Terapi Wicara',
        // tambah sesuai kebutuhan
      ],
      selectedValue: this.modelValue
    }
  },
  watch: {
    selectedValue(newVal) {
      this.$emit('update:modelValue', newVal)
    },
    modelValue(newVal) {
      this.selectedValue = newVal
    }
  }
}
</script>
