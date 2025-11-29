import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { authService, type User, type LoginCredentials, type RegisterData } from '@/services/auth.service'

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const token = ref<string | null>(null)
  const loading = ref(false)
  const error = ref<string | null>(null)

  const isAuthenticated = computed(() => !!token.value)

  function initializeAuth() {
    const storedToken = localStorage.getItem('token')
    const storedUser = localStorage.getItem('user')

    if (storedToken && storedUser) {
      token.value = storedToken
      user.value = JSON.parse(storedUser)
    }
  }

  async function login(credentials: LoginCredentials) {
    loading.value = true
    error.value = null
    try {
      const response = await authService.login(credentials)
      user.value = response.data.user
      token.value = response.data.token

      localStorage.setItem('token', response.data.token)
      localStorage.setItem('user', JSON.stringify(response.data.user))

      return true
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Login failed'
      return false
    } finally {
      loading.value = false
    }
  }

  async function register(data: RegisterData) {
    loading.value = true
    error.value = null
    try {
      const response = await authService.register(data)
      user.value = response.data.user
      token.value = response.data.token

      localStorage.setItem('token', response.data.token)
      localStorage.setItem('user', JSON.stringify(response.data.user))

      return true
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Registration failed'
      return false
    } finally {
      loading.value = false
    }
  }

  async function logout() {
    try {
      await authService.logout()
    } catch (err) {
      console.error('Logout error:', err)
    } finally {
      user.value = null
      token.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }

  async function fetchCurrentUser() {
    if (!token.value) return

    try {
      const userData = await authService.getCurrentUser()
      user.value = userData
      localStorage.setItem('user', JSON.stringify(userData))
    } catch (err) {
      console.error('Failed to fetch user:', err)
      logout()
    }
  }

  return {
    user,
    token,
    loading,
    error,
    isAuthenticated,
    initializeAuth,
    login,
    register,
    logout,
    fetchCurrentUser
  }
})
