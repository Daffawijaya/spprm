<template>
  <nav class="text-sm text-gray-500 mb-2">
    <span v-for="(segment, index) in segments" :key="index">
      <span v-if="index !== 0"> &gt; </span>
      <span class="capitalize">
        {{ formatSegment(segment) }}
      </span>
    </span>
  </nav>
</template>

<script>
export default {
  name: 'Breadcrumb',
  computed: {
    segments() {
      return this.$route.path.replace(/^\/+/, "").split("/");
    }
  },
  methods: {
    formatSegment(text) {
      return text
        .replace(/-/g, " ") // Strip jadi spasi
        .replace(/\b\w/g, c => c.toUpperCase()); // Kapital tiap kata
    }
  }
};
</script>
