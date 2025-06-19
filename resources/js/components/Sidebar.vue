<template>

  <nav class="bg-[#4047F3] w-48 min-h-screen  pt-8 text-white space-y-22">
    <div class="flex flex-row items-center gap-x-3 justify-center">
      <img src="http://localhost:8000/image/parikesit.png" alt="Foto Profil" class="w-10 h-10" />
      <p class="font-black text-lg">Parikesit</p>
    </div>
    <ul class="pl-3">
      <li v-for="item in menuItems" :key="item.to" class="relative py-3 text-sm"
        :class="{ 'with-right-bump': isActiveRoute(item.to) }">
        <router-link :to="item.to" :class="{
          'pl-5 text-[#4047F3]': isActiveRoute(item.to),
          'pl-5 hover:text-blue-200 transition duration-200': !isActiveRoute(item.to)
        }">
          {{ item.label }}
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()

const menuItems = [
  { to: '/', label: 'Dashboard' },
  { to: '/jadwal-terapi', label: 'Jadwal Terapi' },
  { to: '/daftar-pasien', label: 'Daftar Pasien' },
  { to: '/tambah-pasien', label: 'Tambah Pasien' },
  { to: '/reschedule', label: 'Reschedule' },
  { to: '/qa', label: 'Q&A' }
]

function isActiveRoute(path) {
  if (path === '/') {
    return route.path === '/'
  }
  return route.path.startsWith(path)
}

</script>

<style scoped>
.with-right-bump {
  position: relative;
  width: 200px;
  /* background of main div*/
  background: #EFF2F9;
  border-radius: 30px 0 20px 30px;
  display: grid;
  place-items: left;

}

.with-right-bump :after {
  content: "";
  position: absolute;
  top: -40px;
  right: 20px;
  height: 40px;
  width: 40px;
  background: transparent;

  /* border-radius of pseudo element */
  border-bottom-right-radius: 60%;

  /* box shadow to give the shadow of the pseudo-element the same color as the background */
  box-shadow: 0 20px 0 0 #EFF2F9;
}

.with-right-bump :before {
  content: "";
  position: absolute;
  bottom: -40px;
  right: 20px;
  height: 40px;
  width: 40px;
  background: transparent;

  /* border-radius of pseudo element */
  border-top-right-radius: 60%;

  /* box shadow to give the shadow of the pseudo-element the same color as the background */
  box-shadow: 0 -20px 0 0 #EFF2F9;
}
</style>
