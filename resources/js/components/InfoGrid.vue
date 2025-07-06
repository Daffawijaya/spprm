<template>
  <div class="mb-4">
    <div class="flex flex-wrap gap-y-5 gap-x-6">
      <div v-for="(item, index) in items" :key="index" class="flex flex-col gap-y-2">
        <p class="uppercase text-[#969696] text-sm font-light">{{ item.label }}</p>
        <p class="text-base capitalize">{{ item.value || '-' }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    required: true,
    default: () => []
  }
})
</script>
