<template>
  <div class="overflow-x-auto">
    <table class="w-full table-auto border-y border-[#E8EDF0] text-left">
      <thead class="bg-white">
        <tr class="border-b border-[#E8EDF0]">
          <!-- Loop through dynamic headers -->
          <th
            v-for="(header, idx) in headers"
            :key="idx"
            class="uppercase text-[#FF7D3F] text-sm font-light px-8 py-2 whitespace-nowrap"
            :style="{ width: colWidth }"
          >
            {{ header }}
          </th>
          <!-- Actions column -->
          <th
            v-if="actions.length"
            class="uppercase text-[#FF7D3F] font-light text-sm px-8 py-2 text-center"
            style="width: auto"
          >
            Aksi
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, rowIndex) in items"
          :key="rowIndex"
          :class="rowIndex % 2 === 1 ? 'bg-[#F9FAFF]' : 'bg-white'"
        >
          <!-- Render each cell based on keys -->
          <td
            v-for="(key, idx) in keys"
            :key="idx"
            class="text-base px-8 py-5 whitespace-nowrap"
            :style="{ width: colWidth }"
          >
            {{ item[key] }}
          </td>
          <!-- Actions buttons -->
          <td
            v-if="actions.length"
            class="text-bas px-8 py-5 space-x-2 text-center"
            style="width: auto"
          >
            <button
              v-for="action in actions"
              :key="action.name"
              @click="$emit(action.event, item)"
              class="text-sm text-blue-600 hover:underline"
            >
              {{ action.label }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    headers: {
      type: Array,
      required: true
    },
    keys: {
      type: Array,
      required: true
    },
    items: {
      type: Array,
      default: () => []
    },
    actions: {
      type: Array,
      default: () => []
    }
  },
  computed: {
    // calculate equal width per column based on number of headers + action column (if exists)
    colWidth() {
      const totalCols = this.headers.length + (this.actions.length ? 1 : 0);
      return `${(100 / totalCols).toFixed(2)}%`;
    }
  }
}
</script>
