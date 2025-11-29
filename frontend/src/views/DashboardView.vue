<template>
  <div>
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="card">
        <h3 class="text-sm font-medium text-gray-500">Total Goals</h3>
        <p class="text-3xl font-bold text-primary-600 mt-2">{{ stats.totalGoals }}</p>
      </div>
      <div class="card">
        <h3 class="text-sm font-medium text-gray-500">Active Habits</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ stats.activeHabits }}</p>
      </div>
      <div class="card">
        <h3 class="text-sm font-medium text-gray-500">Reading List</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ stats.readingItems }}</p>
      </div>
      <div class="card">
        <h3 class="text-sm font-medium text-gray-500">Daily Goals</h3>
        <p class="text-3xl font-bold text-purple-600 mt-2">{{ stats.dailyGoals }}</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="card">
        <h2 class="text-xl font-bold mb-4">Recent Goals</h2>
        <div v-if="loading" class="text-center py-8">Loading...</div>
        <div v-else-if="recentGoals.length === 0" class="text-center py-8 text-gray-500">
          No goals yet. <RouterLink to="/goals" class="text-primary-600 hover:underline">Create one</RouterLink>
        </div>
        <ul v-else class="space-y-3">
          <li v-for="goal in recentGoals" :key="goal._id" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div>
              <p class="font-medium">{{ goal.goal }}</p>
              <p class="text-sm text-gray-500">Due: {{ formatDate(goal.deadline) }}</p>
            </div>
            <span class="px-2 py-1 text-xs font-semibold rounded-full" :class="getPriorityColor(goal.priority)">
              {{ goal.priority }}
            </span>
          </li>
        </ul>
      </div>

      <div class="card">
        <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-4">
          <RouterLink to="/goals" class="flex flex-col items-center justify-center p-6 bg-primary-50 hover:bg-primary-100 rounded-lg transition-colors">
            <span class="text-3xl mb-2">🎯</span>
            <span class="font-medium">Add Goal</span>
          </RouterLink>
          <RouterLink to="/daily-goals" class="flex flex-col items-center justify-center p-6 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
            <span class="text-3xl mb-2">📅</span>
            <span class="font-medium">Daily Goal</span>
          </RouterLink>
          <RouterLink to="/habits" class="flex flex-col items-center justify-center p-6 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
            <span class="text-3xl mb-2">✓</span>
            <span class="font-medium">Track Habit</span>
          </RouterLink>
          <RouterLink to="/reading-list" class="flex flex-col items-center justify-center p-6 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
            <span class="text-3xl mb-2">📚</span>
            <span class="font-medium">Add Book</span>
          </RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { useGoalsStore } from '@/stores/goals'
import type { Goal } from '@/types'
import { format } from 'date-fns'

const goalsStore = useGoalsStore()
const loading = ref(false)
const recentGoals = ref<Goal[]>([])
const stats = ref({
  totalGoals: 0,
  activeHabits: 0,
  readingItems: 0,
  dailyGoals: 0
})

onMounted(async () => {
  loading.value = true
  await goalsStore.fetchGoals()
  recentGoals.value = goalsStore.goals.slice(0, 5)
  stats.value.totalGoals = goalsStore.goals.length
  loading.value = false
})

function formatDate(dateString: string): string {
  return format(new Date(dateString), 'MMM d, yyyy')
}

function getPriorityColor(priority: string): string {
  const colors: Record<string, string> = {
    A: 'bg-red-100 text-red-800',
    B: 'bg-yellow-100 text-yellow-800',
    C: 'bg-blue-100 text-blue-800',
    D: 'bg-gray-100 text-gray-800'
  }
  return colors[priority] || colors.D
}
</script>
