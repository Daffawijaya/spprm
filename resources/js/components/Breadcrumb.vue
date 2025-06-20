<template>
  <nav class="text-sm text-gray-500">
    <span v-for="(segment, index) in formattedSegments" :key="index">
      <span v-if="index !== 0"> &gt; </span>
      <span class="capitalize">
        {{ segment }}
      </span>
    </span>
  </nav>
</template>

<script>
export default {
  name: 'Breadcrumb',
  computed: {
    formattedSegments() {
      const path = this.$route.path.replace(/^\/+/, "")
      if (!path) return ['Dashboard']

      return path.split("/").map(this.formatSegment)
    }
  },
  methods: {
    formatSegment(text) {
      return text
        .replace(/-/g, " ")
        .replace(/\b\w/g, c => c.toUpperCase())
    }
  }
}
</script>
