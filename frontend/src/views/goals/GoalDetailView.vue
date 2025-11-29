<template>
  <div>
    <button @click="$router.back()" class="mb-6 text-primary-600 hover:text-primary-700">&larr; Back to Goals</button>

    <div v-if="goalsStore.loading" class="text-center py-12">
      <p class="text-gray-500">Loading...</p>
    </div>

    <div v-else-if="goal" class="space-y-6">
      <!-- Goal Details Card -->
      <div class="card">
        <div class="flex justify-between items-start mb-6">
          <div class="flex-1">
            <div class="flex items-center gap-3 mb-4">
              <span class="px-3 py-1 text-sm font-semibold rounded-full" :class="getPriorityColor(goal.priority)">
                Priority {{ goal.priority }}
              </span>
              <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">{{ goal.type }}</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ goal.goal }}</h1>
          </div>
          <button @click="handleDelete" class="btn btn-danger">Delete Goal</button>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
          <div>
            <p class="text-sm text-gray-500">Status</p>
            <p class="font-semibold">{{ goal.status }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Stage</p>
            <p class="font-semibold">{{ goal.stage }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Deadline</p>
            <p class="font-semibold">{{ formatDate(goal.deadline) }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">SMART Goal</p>
            <p class="font-semibold">{{ goal.smart ? 'Yes' : 'No' }}</p>
          </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-6">
          <div class="flex justify-between items-center mb-2">
            <p class="text-sm font-semibold text-gray-700">Progress</p>
            <p class="text-sm font-bold text-primary-600">{{ progress }}%</p>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div
              class="h-full rounded-full transition-all duration-500 ease-out"
              :class="getProgressColor(progress)"
              :style="{ width: progress + '%' }"
            ></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">
            {{ completedTasksCount }} of {{ totalTasksCount }} tasks completed
          </p>
        </div>

        <div class="pt-6 border-t">
          <p class="text-sm text-gray-500">Created: {{ formatDate(goal.createdAt) }}</p>
          <p class="text-sm text-gray-500">Last updated: {{ formatDate(goal.updatedAt) }}</p>
        </div>
      </div>

      <!-- Tasks Section -->
      <div class="card">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-gray-900">Tasks</h2>
          <button @click="addNewTask" class="btn btn-primary">+ New Task</button>
        </div>

        <div v-if="tasksStore.loading && tasksStore.tasks.length === 0" class="text-center py-12">
          <p class="text-gray-500">Loading tasks...</p>
        </div>

        <div v-else-if="tasksStore.tasks.length === 0" class="text-center py-12">
          <p class="text-gray-500 mb-4">No tasks yet. Add your first task to get started!</p>
          <button @click="addNewTask" class="btn btn-primary">Add Task</button>
        </div>

        <div v-else class="ag-theme-alpine" style="height: 500px; width: 100%;">
          <AgGridVue
            :rowData="rowData"
            :columnDefs="columnDefs"
            :defaultColDef="defaultColDef"
            :pagination="true"
            :paginationPageSize="10"
            style="width: 100%; height: 100%;"
            @grid-ready="onGridReady"
            @cell-value-changed="onCellValueChanged"
            :rowHeight="50"
            :animateRows="true"
            :enableCellTextSelection="true"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { AgGridVue } from 'ag-grid-vue3'
import { ModuleRegistry, AllCommunityModule } from 'ag-grid-community'
import type { ColDef, GridApi, GridReadyEvent, CellValueChangedEvent } from 'ag-grid-community'
import { useGoalsStore } from '@/stores/goals'
import { useTasksStore } from '@/stores/tasks'
import { format } from 'date-fns'
import type { Goal, Task } from '@/types'
import 'ag-grid-community/styles/ag-grid.css'
import 'ag-grid-community/styles/ag-theme-alpine.css'

ModuleRegistry.registerModules([AllCommunityModule])

const route = useRoute()
const router = useRouter()
const goalsStore = useGoalsStore()
const tasksStore = useTasksStore()
const goal = ref<Goal | null>(null)
const gridApi = ref<GridApi | null>(null)

const rowData = computed(() => tasksStore.tasks)

const progress = computed(() => tasksStore.getTaskProgress(tasksStore.tasks))
const completedTasksCount = computed(() => tasksStore.tasks.filter(t => t.status === 'Completed').length)
const totalTasksCount = computed(() => tasksStore.tasks.length)

const defaultColDef: ColDef = {
  sortable: true,
  filter: true,
  resizable: true,
  editable: true,
  flex: 1
}

const columnDefs: ColDef[] = [
  {
    headerName: 'Task',
    field: 'task',
    editable: true,
    flex: 2,
    minWidth: 200,
    cellStyle: { 'white-space': 'normal', 'line-height': '1.5', 'padding-top': '10px', 'padding-bottom': '10px' }
  },
  {
    headerName: 'Priority',
    field: 'priority',
    editable: true,
    width: 120,
    cellEditor: 'agSelectCellEditor',
    cellEditorParams: {
      values: ['A', 'B', 'C', 'D']
    },
    cellStyle: (params) => {
      const colors: Record<string, any> = {
        A: { backgroundColor: '#fee2e2', color: '#991b1b', fontWeight: '600' },
        B: { backgroundColor: '#fef3c7', color: '#92400e', fontWeight: '600' },
        C: { backgroundColor: '#dbeafe', color: '#1e40af', fontWeight: '600' },
        D: { backgroundColor: '#f3f4f6', color: '#374151', fontWeight: '600' }
      }
      return colors[params.value] || colors.D
    }
  },
  {
    headerName: 'Status',
    field: 'status',
    editable: true,
    width: 140,
    cellEditor: 'agSelectCellEditor',
    cellEditorParams: {
      values: ['Not Started', 'In Progress', 'On Hold', 'Completed', 'Cancelled']
    },
    cellStyle: (params) => {
      const colors: Record<string, any> = {
        'Not Started': { backgroundColor: '#f3f4f6', color: '#374151' },
        'In Progress': { backgroundColor: '#dbeafe', color: '#1e40af' },
        'On Hold': { backgroundColor: '#fef3c7', color: '#92400e' },
        'Completed': { backgroundColor: '#d1fae5', color: '#065f46' },
        'Cancelled': { backgroundColor: '#fee2e2', color: '#991b1b' }
      }
      return colors[params.value] || {}
    }
  },
  {
    headerName: 'Due Date',
    field: 'duedate',
    editable: true,
    width: 130,
    cellEditor: 'agDateStringCellEditor',
    valueFormatter: (params) => {
      if (!params.value) return ''
      const date = new Date(params.value)
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
    }
  },
  {
    headerName: 'Assigned To',
    field: 'assignedTo',
    editable: true,
    width: 130
  },
  {
    headerName: 'Actions',
    field: 'actions',
    editable: false,
    sortable: false,
    filter: false,
    width: 100,
    cellRenderer: (params: any) => {
      const container = document.createElement('div')
      container.style.display = 'flex'
      container.style.gap = '8px'
      container.style.alignItems = 'center'
      container.style.height = '100%'

      const deleteBtn = document.createElement('button')
      deleteBtn.innerHTML = '🗑️'
      deleteBtn.className = 'text-sm px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600'
      deleteBtn.onclick = () => deleteTask(params.data._id)

      container.appendChild(deleteBtn)
      return container
    }
  }
]

onMounted(async () => {
  const id = route.params.id as string
  goal.value = await goalsStore.fetchGoal(id)
  if (goal.value) {
    await tasksStore.fetchTasksByGoal(goal.value._id)
  }
})

function onGridReady(params: GridReadyEvent) {
  gridApi.value = params.api
  params.api.sizeColumnsToFit()
}

async function onCellValueChanged(event: CellValueChangedEvent) {
  const updatedTask = event.data as Task

  if (!updatedTask._id) return

  const updates: Partial<Task> = {
    [event.column.getColId()]: event.newValue
  }

  const success = await tasksStore.updateTask(updatedTask._id, updates)

  if (!success) {
    event.node.setDataValue(event.column.getColId(), event.oldValue)
  }
}

async function addNewTask() {
  if (!goal.value) return

  const newTaskData = {
    goalId: goal.value._id,
    task: 'New Task - Click to edit',
    priority: 'B' as 'A' | 'B' | 'C' | 'D',
    status: 'Not Started',
    duedate: new Date().toISOString().split('T')[0],
    assignedTo: ''
  }

  const created = await tasksStore.createTask(newTaskData)

  if (created && gridApi.value) {
    setTimeout(() => {
      const rowIndex = tasksStore.tasks.findIndex(t => t._id === created._id)
      if (rowIndex >= 0) {
        gridApi.value?.ensureIndexVisible(rowIndex)
        gridApi.value?.flashCells({ rowNodes: [gridApi.value.getRowNode(String(rowIndex))!] })
      }
    }, 100)
  }
}

async function deleteTask(taskId: string) {
  if (confirm('Are you sure you want to delete this task?')) {
    await tasksStore.deleteTask(taskId)
  }
}

async function handleDelete() {
  if (confirm('Are you sure you want to delete this goal and all its tasks?')) {
    const success = await goalsStore.deleteGoal(goal.value!._id)
    if (success) {
      router.push('/goals')
    }
  }
}

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

function getProgressColor(progress: number): string {
  if (progress === 100) return 'bg-green-500'
  if (progress >= 75) return 'bg-blue-500'
  if (progress >= 50) return 'bg-yellow-500'
  if (progress >= 25) return 'bg-orange-500'
  return 'bg-red-500'
}
</script>

<style scoped>
.ag-theme-alpine {
  --ag-borders: solid 1px #e5e7eb;
  --ag-row-hover-color: #f3f4f6;
  --ag-selected-row-background-color: #dbeafe;
  --ag-header-background-color: #f9fafb;
  --ag-font-size: 14px;
}

.ag-theme-alpine .ag-header-cell-label {
  font-weight: 600;
  color: #374151;
}

.ag-theme-alpine .ag-cell {
  display: flex;
  align-items: center;
}

.ag-theme-alpine .ag-root-wrapper {
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  overflow: hidden;
}
</style>
