import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'
import type { Task, ApiResponse } from '@/types'

export const useTasksStore = defineStore('tasks', () => {
  const tasks = ref<Task[]>([])
  const currentTask = ref<Task | null>(null)
  const loading = ref(false)
  const error = ref<string | null>(null)

  async function fetchTasksByGoal(goalId: string) {
    loading.value = true
    error.value = null
    try {
      const response = await api.get<ApiResponse<{ tasks: Task[] }>>(`/tasks/goal/${goalId}`)
      tasks.value = response.data.data.tasks
      return response.data.data.tasks
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch tasks'
      console.error('Fetch tasks error:', err)
      return []
    } finally {
      loading.value = false
    }
  }

  async function fetchTask(id: string) {
    loading.value = true
    error.value = null
    try {
      const response = await api.get<ApiResponse<{ task: Task }>>(`/tasks/${id}`)
      currentTask.value = response.data.data.task
      return response.data.data.task
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch task'
      return null
    } finally {
      loading.value = false
    }
  }

  async function createTask(taskData: Partial<Task> & { goalId: string }) {
    loading.value = true
    error.value = null
    try {
      const { goalId, ...rest } = taskData
      const response = await api.post<ApiResponse<{ task: Task }>>(`/tasks/goal/${goalId}`, rest)
      tasks.value.push(response.data.data.task)
      return response.data.data.task
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to create task'
      console.error('Create task error:', err)
      return null
    } finally {
      loading.value = false
    }
  }

  async function updateTask(id: string, taskData: Partial<Task>) {
    loading.value = true
    error.value = null
    try {
      const response = await api.put<ApiResponse<{ task: Task }>>(`/tasks/${id}`, taskData)
      const index = tasks.value.findIndex(t => t._id === id)
      if (index !== -1) {
        tasks.value[index] = response.data.data.task
      }
      return true
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to update task'
      console.error('Update task error:', err)
      return false
    } finally {
      loading.value = false
    }
  }

  async function deleteTask(id: string) {
    loading.value = true
    error.value = null
    try {
      await api.delete(`/tasks/${id}`)
      tasks.value = tasks.value.filter(t => t._id !== id)
      return true
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to delete task'
      console.error('Delete task error:', err)
      return false
    } finally {
      loading.value = false
    }
  }

  function getTaskProgress(goalTasks: Task[]) {
    if (goalTasks.length === 0) return 0
    const completed = goalTasks.filter(t => t.status === 'Completed').length
    return Math.round((completed / goalTasks.length) * 100)
  }

  return {
    tasks,
    currentTask,
    loading,
    error,
    fetchTasksByGoal,
    fetchTask,
    createTask,
    updateTask,
    deleteTask,
    getTaskProgress
  }
})
