// stores/auth.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
    user: null
  }),
  actions: {
    async login(email, password) {
      try {
        const res = await axios.post('http://localhost:8000/api/auth/login', {
          email,
          password
        })
        this.token = res.data.access_token
        localStorage.setItem('token', this.token)

        // Set default Authorization header
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`

        // Fetch user info
        const me = await axios.get('http://localhost:8000/api/auth/me')
        this.user = me.data
      } catch (err) {
        throw err
      }
    },
    logout() {
      this.token = null
      this.user = null
      localStorage.removeItem('token')
      delete axios.defaults.headers.common['Authorization']
    }
  }
})
