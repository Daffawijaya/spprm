<template>
  <nav class="bg-gray-200 w-48 min-h-screen p-4">
    <ul>
      <li class="mb-2"><router-link to="/">Dashboard</router-link></li>
      <li class="mb-2"><router-link to="/jadwal-terapi">Jadwal Terapi</router-link></li>
      <li class="mb-2"><router-link to="/daftar-pasien">Daftar Pasien</router-link></li>
      <li class="mb-2"><router-link to="/tambah-pasien">Tambah Pasien</router-link></li>
      <li class="mb-2"><router-link to="/reschedule">Reschedule</router-link></li>
      <li class="mb-2"><router-link to="/qa">Q&A</router-link></li>
    </ul>
  </nav>
</template>

<script>
export default { name: 'Sidebar' };
</script>

<style scoped>
nav ul {
  list-style: none;
  padding: 0;
}

nav a {
  text-decoration: none;
  color: #333;
}

nav a.router-link-active {
  font-weight: bold;
}
</style>