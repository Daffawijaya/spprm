// src/stores/bulanStore.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useBulanStore = defineStore('bulan', {
  state: () => ({
    jenisTerapi: null,
    tanggalList: [],
  }),

  actions: {
    async fetchTanggalList(tahun, bulan) {
      try {
        const response = await axios.get('/api/status/bulan', {
          params: {
            tahun,
            bulan,
            jenis_terapi: this.jenisTerapi,
          },
        })

        this.tanggalList = response.data.map(item => ({
          tanggal: item.tanggal,
          penuh: item.status === 'penuh',
        }))
      } catch (error) {
        console.error('Gagal mengambil data status bulan:', error)
      }
    },

    setJenisTerapi(jenis) {
      this.jenisTerapi = jenis
    },
  },
})
