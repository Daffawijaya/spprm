<template>
  <div class="relative w-full">
    <!-- Card belakang (dinamis dari props) -->
    <div class="absolute inset-0 rounded-2xl z-0" :class="bgColor"></div>

    <!-- Card utama -->
    <div class="relative bg-white rounded-2xl shadow p-6 overflow-hidden translate-x-2">
      <div class="flex items-center justify-between">
        <!-- Kiri -->
        <div class="flex flex-col justify-between h-full">
          <p class="text-sm font-semibold text-gray-500 mb-2">{{ title }}</p>
          <component :is="icon" class="w-10 h-10 text-black " />
          <PrimaryButton class="mt-4" :color="buttonColor" @click="$emit('action')">
            {{ buttonText }}
          </PrimaryButton>
        </div>

        <!-- Kanan -->
        <div class="flex flex-col items-end">
          <p class="text-4xl font-medium text-gray-800">{{ value }}</p>
          <p class="text-xs text-gray-500">{{ valueLabel }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PrimaryButton from '@/components/PrimaryButton.vue'

defineProps({
  title: String,
  value: [String, Number],
  valueLabel: String,
  icon: Object,
  buttonText: { type: String, default: 'Lihat' },
  bgColor: { type: String, default: 'bg-[#ADDC8B]' }, // contoh: 'bg-[#E0EEDC]' atau 'bg-green-100'
  buttonColor: { type: String, default: 'green' }      // opsi: green, red, orange
})
</script>
