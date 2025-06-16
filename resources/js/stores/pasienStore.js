// stores/pasienStore.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const usePasienStore = defineStore('pasien', {
state: () => ({
  pasienList: [],
  pasien: {}, // Tambahkan ini
  loading: false,
  error: null
}),

  actions: {
    // GET
    async fetchPasien() {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/api/pasien')
        this.pasienList = response.data
      } catch (err) {
        this.error = err
        console.error('Gagal fetch data pasien:', err)
      } finally {
        this.loading = false
      }
    },

    async getPasienById(id) {
  this.loading = true
  try {
    const res = await axios.get(`/api/pasien/${id}`)
    this.pasien = res.data // <-- simpan ke state
    return res.data
  } catch (err) {
    this.error = err
    console.error('Gagal ambil pasien:', err)
    return null
  } finally {
    this.loading = false
  }
},


    // CREATE
    async createPasien(data) {
      this.loading = true
      try {
        const response = await axios.post('/api/pasien', data)
        this.pasienList.push(response.data) // update local list
      } catch (err) {
        this.error = err
        console.error('Gagal tambah pasien:', err)
      } finally {
        this.loading = false
      }
    },

    // UPDATE
    async updatePasien(id, data) {
      this.loading = true
      try {
        const response = await axios.put(`/api/pasien/${id}`, data)
        // Update item di pasienList
        const index = this.pasienList.findIndex(p => p.id === id)
        if (index !== -1) {
          this.pasienList[index] = response.data
        }
      } catch (err) {
        this.error = err
        console.error('Gagal update pasien:', err)
      } finally {
        this.loading = false
      }
    },

    // DELETE
    async deletePasien(id) {
      this.loading = true
      try {
        await axios.delete(`/api/pasien/${id}`)
        // Hapus dari list lokal
        this.pasienList = this.pasienList.filter(p => p.id !== id)
      } catch (err) {
        this.error = err
        console.error('Gagal hapus pasien:', err)
      } finally {
        this.loading = false
      }
    }
  }
})
