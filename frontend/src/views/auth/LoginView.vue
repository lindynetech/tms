<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-500 to-primary-700 px-4">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-2xl">
      <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900">TMS</h2>
        <p class="mt-2 text-sm text-gray-600">Time Management System</p>
      </div>

      <form @submit.prevent="handleLogin" class="mt-8 space-y-6">
        <div v-if="authStore.error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
          {{ authStore.error }}
        </div>

        <div>
          <label for="email" class="label">Email</label>
          <input
            id="email"
            v-model="credentials.email"
            type="email"
            required
            class="input"
            placeholder="you@example.com"
          />
        </div>

        <div>
          <label for="password" class="label">Password</label>
          <input
            id="password"
            v-model="credentials.password"
            type="password"
            required
            class="input"
            placeholder="••••••••"
          />
        </div>

        <button
          type="submit"
          :disabled="authStore.loading"
          class="w-full btn btn-primary"
        >
          {{ authStore.loading ? 'Logging in...' : 'Log in' }}
        </button>

        <p class="text-center text-sm text-gray-600">
          Don't have an account?
          <RouterLink to="/register" class="font-medium text-primary-600 hover:text-primary-500">
            Sign up
          </RouterLink>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const credentials = reactive({
  email: '',
  password: ''
})

async function handleLogin() {
  const success = await authStore.login(credentials)
  if (success) {
    router.push('/')
  }
}
</script>
