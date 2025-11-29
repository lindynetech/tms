import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'
import type { Goal, ApiResponse } from '@/types'

export const useGoalsStore = defineStore('goals', () => {
  const goals = ref<Goal[]>([])
  const currentGoal = ref<Goal | null>(null)
  const loading = ref(false)
  const error = ref<string | null>(null)

  async function fetchGoals() {
    loading.value = true
    error.value = null
    try {
      const response = await api.get<ApiResponse<{ goals: Goal[] }>>('/goals')
      goals.value = response.data.data.goals
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch goals'
    } finally {
      loading.value = false
    }
  }

  async function fetchGoal(id: string) {
    loading.value = true
    error.value = null
    try {
      const response = await api.get<ApiResponse<{ goal: Goal }>>(`/goals/${id}`)
      currentGoal.value = response.data.data.goal
      return response.data.data.goal
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch goal'
      return null
    } finally {
      loading.value = false
    }
  }

  async function createGoal(goalData: Partial<Goal>) {
    loading.value = true
    error.value = null
    try {
      const response = await api.post<ApiResponse<{ goal: Goal }>>('/goals', goalData)
      goals.value.push(response.data.data.goal)
      return response.data.data.goal
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to create goal'
      return null
    } finally {
      loading.value = false
    }
  }

  async function updateGoal(id: string, goalData: Partial<Goal>) {
    loading.value = true
    error.value = null
    try {
      const response = await api.put<ApiResponse<{ goal: Goal }>>(`/goals/${id}`, goalData)
      const index = goals.value.findIndex(g => g._id === id)
      if (index !== -1) {
        goals.value[index] = response.data.data.goal
      }
      return true
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to update goal'
      console.error('Update goal error:', err)
      return false
    } finally {
      loading.value = false
    }
  }

  async function deleteGoal(id: string) {
    loading.value = true
    error.value = null
    try {
      await api.delete(`/goals/${id}`)
      goals.value = goals.value.filter(g => g._id !== id)
      return true
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to delete goal'
      return false
    } finally {
      loading.value = false
    }
  }

  return {
    goals,
    currentGoal,
    loading,
    error,
    fetchGoals,
    fetchGoal,
    createGoal,
    updateGoal,
    deleteGoal
  }
})
