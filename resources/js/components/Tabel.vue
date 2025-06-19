<!-- Tabel.vue -->
<template>
  <div class="overflow-x-auto">
    <table class="w-full table-auto border-y border-[#E8EDF0] text-left">
      <thead class="bg-white">
        <tr class="border-b border-[#E8EDF0]">
          <th v-for="(header, idx) in headers" :key="idx"
            class="uppercase text-[#FF7D3F] text-sm font-light px-8 py-2 whitespace-nowrap"
            :style="{ width: colWidth }">
            {{ header }}
          </th>
          <th v-if="$slots.actions" class="uppercase text-[#FF7D3F] font-light text-sm px-8 py-2 text-center">
            Aksi
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, rowIndex) in items" :key="rowIndex" :class="rowIndex % 2 === 1 ? 'bg-[#F6F8FE]' : 'bg-white'">
          <td v-for="(key, idx) in keys" :key="idx" class="text-base px-8 py-5 whitespace-nowrap"
            :style="{ width: colWidth }">
            {{ item[key] }}
          </td>
          <td v-if="$slots.actions" class="px-8 py-5 text-center">
            <slot name="actions" :item="item" :emit="$emit" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    headers: Array,
    keys: Array,
    items: Array
  },
  computed: {
    colWidth() {
      const totalCols = this.headers.length + (this.$slots.actions ? 1 : 0)
      return `${(100 / totalCols).toFixed(2)}%`
    }
  }
}
</script>