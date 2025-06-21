<template>
  <div :class="bgClass" class="p-6 rounded-lg shadow text-center flex flex-col items-center">
    <component :is="icon" class="h-12 w-12 mb-4 text-current" />
    <h4 class="text-xl font-semibold mb-2">{{ title }}</h4>
    <p class="text-gray-600">{{ desc }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  icon: {
    type: [Object, Function],
    required: true
  },
  title: String,
  desc: String,
  color: {
    type: String,
    default: 'blue'
  }
})

const bgClass = {
  blue: 'bg-blue-50 text-blue-700',
  green: 'bg-green-50 text-green-700',
  orange: 'bg-orange-50 text-orange-700',
  purple: 'bg-purple-50 text-purple-700'
}[props.color]
</script>
