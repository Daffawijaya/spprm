<template>
  <div class="bg-white p-6 rounded-lg shadow text-center">
    <p class="italic text-gray-600 mb-4">“{{ msg }}”</p>
    <h5 class="font-bold text-gray-800">{{ name }}</h5>
    <div class="mt-2 flex justify-center">
      <span
        v-for="n in +rating"
        :key="n"
        class="text-yellow-400 text-lg"
      >★</span>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  name: String,
  msg: String,
  rating: {
    type: [String, Number],
    default: 5
  }
})
</script>
