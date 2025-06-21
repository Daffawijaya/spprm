<template>
  <div class="flex flex-col items-center">
    <span :class="numClass" class="text-4xl font-bold mb-1">{{ num }}</span>
    <p class="text-gray-700">{{ label }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  num: String,
  label: String,
  color: {
    type: String,
    default: 'blue'
  }
})

const numClass = {
  blue: 'text-blue-600',
  green: 'text-green-600',
  orange: 'text-orange-500',
  purple: 'text-purple-600',
}[props.color] || 'text-gray-800'
</script>
