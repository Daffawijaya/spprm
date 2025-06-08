import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../view/Dashboard.vue';
import JadwalTerapi from '../view/JadwalTerapi.vue';
import DaftarPasien from '../view/pasien/DaftarPasien.vue';
import TambahPasien from '../view/TambahPasien.vue';
import Reschedule from '../view/Reschedule.vue';
import QA from '../view/QA.vue';
import ManajemenPasien from '../view/pasien/ManajemenPasien.vue';
import TambahJadwal from '../view/pasien/Tambahjadwal.vue';

const routes = [
  { path: '/', name: 'Dashboard', component: Dashboard },
  { path: '/jadwal-terapi', name: 'JadwalTerapi', component: JadwalTerapi },
  { path: '/daftar-pasien', name: 'DaftarPasien', component: DaftarPasien },
  { path: '/tambah-pasien', name: 'TambahPasien', component: TambahPasien },
  { path: '/reschedule', name: 'Reschedule', component: Reschedule },
  { path: '/qa', name: 'QA', component: QA },
  { path: '/daftar-pasien/manajemen/:id', name: 'ManajemenPasien', component: ManajemenPasien },
  { path: '/daftar-pasien/:pasienId/tambah-jadwal', name: 'TambahJadwal', component: TambahJadwal, props: true },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;