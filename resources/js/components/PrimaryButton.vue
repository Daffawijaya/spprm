<template>
  <button
    :type="type"
    :class="[
      'text-sm text-white px-4 py-1 rounded-full flex items-center justify-between gap-2',
      colorClass,
      block ? 'w-full' : ''
    ]"
  >
    <slot />
    <slot name="icon" v-if="$slots.icon" />
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  color: { type: String, default: 'green' },
  block: { type: Boolean, default: false },
  type: { type: String, default: 'button' } // ← ini penting!
})

const colorClass = computed(() => {
  return {
    green: 'bg-[#ADDC8B]',
    red: 'bg-red-500',
    orange: 'bg-[#FF7D3F]',
    grey: 'bg-[#CCCCCC]',
    yellow: 'bg-[#FFAC04]',
    purple: 'bg-[#D17AAA]',
    sky: 'bg-[#6CB4EE]'
  }[props.color] || 'bg-[#ADDC8B]'
})
</script>
