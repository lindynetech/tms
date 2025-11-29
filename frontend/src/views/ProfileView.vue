<template>
  <div>
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Profile Settings</h1>
    <div class="card">
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">User Information</h2>
        <div class="space-y-3">
          <div>
            <p class="text-sm text-gray-500">Name</p>
            <p class="font-medium">{{ authStore.user?.name }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="font-medium">{{ authStore.user?.email }}</p>
          </div>
        </div>
      </div>
      <div class="pt-6 border-t">
        <p class="text-gray-600">Profile editing feature - Coming soon!</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>
