// stores/jadwalStore.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useJadwalStore = defineStore('jadwal', {
  state: () => ({
    jadwalList: [],
    pagination: {
      current_page: 1,
      last_page: 1,
      total: 0
    }
  }),
  actions: {
    async fetchByPasien(pasienId, page = 1) {
      const res = await axios.get(`/api/pasien/${pasienId}/jadwal?page=${page}`)
      this.jadwalList = res.data.data
      this.pagination = {
        current_page: res.data.current_page,
        last_page: res.data.last_page,
        total: res.data.total
      }
    },
    async createJadwal(pasienId, data) {
      try {
        const res = await axios.post(`/api/pasien/${pasienId}/jadwal`, data)
        // Optional: Refetch instead of push if pagination used
        await this.fetchByPasien(pasienId, this.pagination.current_page)
        return { success: true, data: res.data }
      } catch (err) {
        if (err.response && err.response.status === 409) {
          return { success: false, message: err.response.data.message }
        }
        throw err
      }
    },
    async deleteJadwal(pasienId, jadwalId) {
      await axios.delete(`/api/pasien/${pasienId}/jadwal/${jadwalId}`)
      await this.fetchByPasien(pasienId, this.pagination.current_page)
    },
    async updateJadwal(pasienId, jadwalId, data) {
      const res = await axios.put(`/api/pasien/${pasienId}/jadwal/${jadwalId}`, data)
      await this.fetchByPasien(pasienId, this.pagination.current_page)
      return res.data
    }
  }
})
