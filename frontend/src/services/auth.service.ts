import api from './api'

export interface LoginCredentials {
  email: string
  password: string
}

export interface RegisterData {
  name: string
  email: string
  password: string
}

export interface User {
  id: string
  name: string
  email: string
}

export interface AuthResponse {
  status: string
  data: {
    user: User
    token: string
    refreshToken: string
  }
}

export const authService = {
  async login(credentials: LoginCredentials): Promise<AuthResponse> {
    const response = await api.post<AuthResponse>('/auth/login', credentials)
    return response.data
  },

  async register(data: RegisterData): Promise<AuthResponse> {
    const response = await api.post<AuthResponse>('/auth/register', data)
    return response.data
  },

  async getCurrentUser(): Promise<User> {
    const response = await api.get<{ status: string; data: { user: User } }>('/auth/me')
    return response.data.data.user
  },

  async logout(): Promise<void> {
    await api.post('/auth/logout')
    localStorage.removeItem('token')
    localStorage.removeItem('user')
  },

  async refreshToken(refreshToken: string): Promise<{ token: string; refreshToken: string }> {
    const response = await api.post<{ status: string; data: { token: string; refreshToken: string } }>(
      '/auth/refresh-token',
      { refreshToken }
    )
    return response.data.data
  }
}
