// stores/jadwalStore.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useJadwalStore = defineStore('jadwal', {
  state: () => ({
    jadwalList: []
  }),
  actions: {
    async fetchByPasien(pasienId) {
      const res = await axios.get(`/api/pasien/${pasienId}/jadwal`)
      this.jadwalList = res.data
    },
    async createJadwal(pasienId, data) {
      try {
        const res = await axios.post(`/api/pasien/${pasienId}/jadwal`, data)
        this.jadwalList.push(res.data)
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
      this.jadwalList = this.jadwalList.filter(j => j.id !== jadwalId)
    },
    async updateJadwal(pasienId, jadwalId, data) {
      const res = await axios.put(`/api/pasien/${pasienId}/jadwal/${jadwalId}`, data)
      const index = this.jadwalList.findIndex(j => j.id === jadwalId)
      if (index !== -1) this.jadwalList[index] = res.data
      return res.data
    }
  }
})
