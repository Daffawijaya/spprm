// src/stores/bulanStore.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useBulanStore = defineStore('bulan', {
  state: () => ({
    jenisTerapi: null,
    tanggalList: [],
    statusSesi: []
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

    async fetchStatusTanggal(tanggal) {
      try {
        const response = await axios.get('/api/status/tanggal', {
          params: {
            tanggal,
            jenis_terapi: this.jenisTerapi,
          },
        })

        this.statusSesi = response.data.sesi
      } catch (error) {
        console.error('Gagal mengambil status sesi:', error)
        this.statusSesi = []
      }
    },

    setJenisTerapi(jenis) {
      this.jenisTerapi = jenis
    },
  },
})
