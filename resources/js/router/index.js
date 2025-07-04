import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../view/Dashboard.vue';
import JadwalTerapi from '../view/jadwal/JadwalTerapi.vue';
import DaftarPasien from '../view/pasien/DaftarPasien.vue';
import TambahPasien from '../view/TambahPasien.vue';
import Reschedule from '../view/Reschedule.vue';
import QA from '../view/QA.vue';
import ManajemenPasien from '../view/pasien/ManajemenPasien.vue';
import TambahEditJadwal from '../view/pasien/TambahEditJadwal.vue';
import EditPasien from '../view/pasien/EditPasien.vue';
import PilihTanggal from '../view/pasien/PilihTanggal.vue';
import PilihSesi from '../view/pasien/PilihSesi.vue';
import SesiTerapi from '../view/jadwal/SesiTerapi.vue';
import PasienSesi from '../view/jadwal/PasienSesi.vue';
import LandingPage from '../view/LandingPage.vue';
import Login from '../view/Login.vue';

const routes = [
  { path: '/', name: 'LandingPage', component: LandingPage },
  { path: '/login', name: 'Login', component: Login },

  { path: '/dashboard', name: 'Dashboard', component: Dashboard },
  { path: '/daftar-pasien', name: 'DaftarPasien', component: DaftarPasien },
  { path: '/tambah-pasien', name: 'TambahPasien', component: TambahPasien },
  { path: '/reschedule', name: 'Reschedule', component: Reschedule },
  { path: '/qa', name: 'QA', component: QA },
  { path: '/daftar-pasien/manajemen/:id', name: 'ManajemenPasien', component: ManajemenPasien },
  { path: '/daftar-pasien/manajemen/:pasienId/terapi/:jenisTerapi/tanggal', name: 'PilihTanggal', component: PilihTanggal, props: true },
  { path: '/daftar-pasien/manajemen/:pasienId/terapi/:jenisTerapi/tanggal/:tanggal/sesi', name: 'PilihSesi', component: PilihSesi, props: true },
  { path: '/daftar-pasien/manajemen/:pasienId/jadwal/:jadwalId?', name: 'TambahEditJadwal', component: TambahEditJadwal, props: true },
  { path: '/daftar-pasien/manajemen/:id/edit', name: 'EditPasien', component: EditPasien, props: true },
  { path: '/jadwal-terapi', name: 'JadwalTerapi', component: JadwalTerapi },
  { path: '/jadwal-terapi/sesi/:tanggal', name: 'SesiTerapi', component: SesiTerapi },
  { path: '/jadwal-terapi/sesi/:tanggal/pasien', name: 'PasienBySesi', component: PasienSesi },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// ROUTES yang tidak perlu login
const PUBLIC_ROUTES = ['LandingPage', 'Login']

// Middleware global
router.beforeEach((to, from, next) => {
  const isLoggedIn = !!localStorage.getItem('token') // sesuaikan jika kamu pakai metode lain

  if (!isLoggedIn && !PUBLIC_ROUTES.includes(to.name)) {
    // jika belum login dan buka halaman bukan publik → redirect ke LandingPage
    next({ name: 'LandingPage' })
  } else {
    next()
  }
})

export default router;
