<template>
  <select v-model="selectedValue" required>
    <option disabled value="">Pilih sesi terapi</option>
    <option v-for="sesi in sesiOptions" :key="sesi.id" :value="sesi.id">
      {{ sesi.label }}
    </option>
  </select>
</template>

<script>
export default {
  props: ['modelValue'],
  emits: ['update:modelValue'],
  data() {
    return {
      sesiOptions: [
        { id: 1, label: 'Sesi 1 (07.30-09.00)' },
        { id: 2, label: 'Sesi 2 (09.00-10.30)' },
        { id: 3, label: 'Sesi 3 (10.30-12.00)' },
        { id: 4, label: 'Sesi 4 (13.00-14.30)' },
        { id: 5, label: 'Sesi 5 (14.30-16.00)' },
        { id: 6, label: 'Sesi 6 (16.00-17.30)' },
      ],
      selectedValue: this.modelValue
    }
  },
  watch: {
    selectedValue(newVal) {
      this.$emit('update:modelValue', newVal);
    },
    modelValue(newVal) {
      this.selectedValue = newVal;
    }
  }
}
</script>
