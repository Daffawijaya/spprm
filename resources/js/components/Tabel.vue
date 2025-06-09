<template>
  <table border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th v-for="header in headers" :key="header">{{ header }}</th>
        <th v-if="actions.length">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in items" :key="index">
        <td v-for="key in keys" :key="key">{{ item[key] }}</td>
        <td v-if="actions.length">
          <button v-for="action in actions" :key="action.name" @click="$emit(action.event, item)"
            style="margin-right: 4px">
            {{ action.label }}
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    headers: Array,      // ['Nama', 'Umur', 'Jenis Kelamin']
    keys: Array,         // ['nama', 'umur', 'jenis_kelamin']
    items: Array,        // list data
    actions: {           // opsional: tombol-tombol aksi
      type: Array,
      default: () => []
    }
  }
}
</script>