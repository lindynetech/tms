<template>
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
      <div class="p-4 border-b border-gray-800">
        <h1 class="text-2xl font-bold">TMS</h1>
        <p class="text-sm text-gray-400">{{ authStore.user?.name }}</p>
      </div>

      <nav class="flex-1 p-4 space-y-1">
        <RouterLink
          v-for="item in navigation"
          :key="item.path"
          :to="item.path"
          class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors"
          :class="{ 'bg-gray-800': $route.path === item.path }"
        >
          <span class="mr-3">{{ item.icon }}</span>
          <span>{{ item.name }}</span>
        </RouterLink>
      </nav>

      <div class="p-4 border-t border-gray-800">
        <button
          @click="handleLogout"
          class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition-colors"
        >
          Logout
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
      <div class="container mx-auto p-8">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { useRouter, RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const navigation = [
  { name: 'Dashboard', path: '/', icon: '📊' },
  { name: 'Goals', path: '/goals', icon: '🎯' },
  { name: 'Daily Goals', path: '/daily-goals', icon: '📅' },
  { name: 'Habits', path: '/habits', icon: '✓' },
  { name: 'Mindstorms', path: '/mindstorms', icon: '💡' },
  { name: 'Reading List', path: '/reading-list', icon: '📚' },
  { name: 'Vendors', path: '/vendors', icon: '👥' },
  { name: 'Profile', path: '/profile', icon: '⚙️' }
]

async function handleLogout() {
  await authStore.logout()
  router.push('/login')
}
</script>
