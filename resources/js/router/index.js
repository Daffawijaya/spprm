import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../view/Dashboard.vue';
import JadwalTerapi from '../view/JadwalTerapi.vue';
import DaftarPasien from '../view/DaftarPasien.vue';
import TambahPasien from '../view/TambahPasien.vue';
import Reschedule from '../view/Reschedule.vue';
import QA from '../view/QA.vue';

const routes = [
  { path: '/', name: 'Dashboard', component: Dashboard },
  { path: '/jadwal-terapi', name: 'JadwalTerapi', component: JadwalTerapi },
  { path: '/daftar-pasien', name: 'DaftarPasien', component: DaftarPasien },
  { path: '/tambah-pasien', name: 'TambahPasien', component: TambahPasien },
  { path: '/reschedule', name: 'Reschedule', component: Reschedule },
  { path: '/qa', name: 'QA', component: QA }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;