// stores/pasienStore.js
import { defineStore } from "pinia";
import axios from "axios";

export const usePasienStore = defineStore("pasien", {
    state: () => ({
        pasienList: [],
        pasienResponse: {
            jadwal: {},
            pasien: [],
        },
        pasien: {},
        loading: false,
        error: null,
        pagination: {
            currentPage: 1,
            perPage: 5,
            total: 0,
        },
    }),

    actions: {
        // GET
        async fetchPasien({ page = 1, perPage = 5, search = "" } = {}) {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get("/api/pasien", {
                    params: { page, per_page: perPage, search },
                });

                // Simpan hanya array pasien
                this.pasienList = response.data.data;

                // (Opsional) bisa simpan meta pagination kalau dibutuhkan di UI
                this.pagination = {
                    currentPage: response.data.current_page,
                    total: response.data.total,
                    lastPage: response.data.last_page,
                    perPage: response.data.per_page,
                };
            } catch (err) {
                this.error = err;
                console.error("Gagal fetch data pasien:", err);
            } finally {
                this.loading = false;
            }
        },

        async getPasienById(id) {
            this.loading = true;
            try {
                const res = await axios.get(`/api/pasien/${id}`);
                this.pasien = res.data.data; // <-- simpan ke state
                return res.data.data;
            } catch (err) {
                this.error = err;
                console.error("Gagal ambil pasien:", err);
                return null;
            } finally {
                this.loading = false;
            }
        },

        // CREATE
        async createPasien(data) {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.post("/api/pasien", data);

                const pasienBaru = response.data.data;
                this.pasienList.push(pasienBaru);

                return {
                    id: pasienBaru.id,
                    message: response.data.message,
                    data: pasienBaru,
                };
            } catch (err) {
                this.error = err;
                if (err.response) throw err.response;
                throw err;
            } finally {
                this.loading = false;
            }
        },

        // UPDATE
        async updatePasien(id, data) {
            this.loading = true;
            try {
                const response = await axios.put(`/api/pasien/${id}`, data);

                // Update item di pasienList jika ada
                const index = this.pasienList.findIndex((p) => p.id === id);
                if (index !== -1) {
                    this.pasienList[index] = response.data;
                }

                return response; // ✅ return supaya bisa ditangkap di komponen
            } catch (err) {
                this.error = err;
                console.error("Gagal update pasien:", err);
                throw err; // ✅ lempar ulang error biar bisa ditangkap di komponen
            } finally {
                this.loading = false;
            }
        },

        // DELETE
        async deletePasien(id) {
            this.loading = true;
            try {
                await axios.delete(`/api/pasien/${id}`);
                // Hapus dari list lokal
                this.pasienList = this.pasienList.filter((p) => p.id !== id);
            } catch (err) {
                this.error = err;
                console.error("Gagal hapus pasien:", err);
            } finally {
                this.loading = false;
            }
        },
        async fetchPasienByTanggalSesi(tanggal, sesi) {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get("/api/pasien/by-jadwal", {
                    params: { tanggal, sesi },
                });
                this.pasienResponse = response.data;
            } catch (err) {
                this.error = err;
                console.error("Gagal fetch pasien berdasarkan sesi:", err);
            } finally {
                this.loading = false;
            }
        },
    },
});
