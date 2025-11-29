<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-500 to-primary-700 px-4">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-2xl">
      <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900">Create Account</h2>
        <p class="mt-2 text-sm text-gray-600">Join TMS today</p>
      </div>

      <form @submit.prevent="handleRegister" class="mt-8 space-y-6">
        <div v-if="authStore.error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
          {{ authStore.error }}
        </div>

        <div>
          <label for="name" class="label">Full Name</label>
          <input
            id="name"
            v-model="registerData.name"
            type="text"
            required
            class="input"
            placeholder="John Doe"
          />
        </div>

        <div>
          <label for="email" class="label">Email</label>
          <input
            id="email"
            v-model="registerData.email"
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
            v-model="registerData.password"
            type="password"
            required
            minlength="6"
            class="input"
            placeholder="••••••••"
          />
        </div>

        <button
          type="submit"
          :disabled="authStore.loading"
          class="w-full btn btn-primary"
        >
          {{ authStore.loading ? 'Creating account...' : 'Sign up' }}
        </button>

        <p class="text-center text-sm text-gray-600">
          Already have an account?
          <RouterLink to="/login" class="font-medium text-primary-600 hover:text-primary-500">
            Log in
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

const registerData = reactive({
  name: '',
  email: '',
  password: ''
})

async function handleRegister() {
  const success = await authStore.register(registerData)
  if (success) {
    router.push('/')
  }
}
</script>
