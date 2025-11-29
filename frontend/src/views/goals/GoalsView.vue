<template>
  <div class="flex flex-col" style="height: calc(100vh - 120px);">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-900">Goals</h1>
      <button @click="addNewGoal" class="btn btn-primary">+ New Goal</button>
    </div>

    <div v-if="goalsStore.loading && goalsStore.goals.length === 0" class="text-center py-12">
      <p class="text-gray-500">Loading goals...</p>
    </div>

    <div v-else class="ag-theme-alpine" style="height: 600px; width: 100%;">
      <AgGridVue
        :rowData="rowData"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :pagination="true"
        :paginationPageSize="20"
        style="width: 100%; height: 100%;"
        @grid-ready="onGridReady"
        @cell-value-changed="onCellValueChanged"
        :rowHeight="60"
        :animateRows="true"
        :enableCellTextSelection="true"
        :ensureDomOrder="true"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { AgGridVue } from 'ag-grid-vue3'
import { ModuleRegistry, AllCommunityModule } from 'ag-grid-community'
import type { ColDef, GridApi, GridReadyEvent, CellValueChangedEvent } from 'ag-grid-community'
import { useGoalsStore } from '@/stores/goals'
import type { Goal } from '@/types'
import 'ag-grid-community/styles/ag-grid.css'
import 'ag-grid-community/styles/ag-theme-alpine.css'

ModuleRegistry.registerModules([AllCommunityModule])

const goalsStore = useGoalsStore()
const gridApi = ref<GridApi | null>(null)

const rowData = computed(() => goalsStore.goals)

const defaultColDef: ColDef = {
  sortable: true,
  filter: true,
  resizable: true,
  editable: true,
  flex: 1
}

const columnDefs: ColDef[] = [
  {
    headerName: 'Goal',
    field: 'goal',
    editable: true,
    flex: 2,
    minWidth: 250,
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
    },
    cellRenderer: (params: any) => {
      const labels: Record<string, string> = {
        A: 'A - High',
        B: 'B - Medium',
        C: 'C - Low',
        D: 'D - Someday'
      }
      return labels[params.value] || params.value
    }
  },
  {
    headerName: 'Urgency',
    field: 'urgency',
    editable: true,
    width: 100,
    cellEditor: 'agNumberCellEditor',
    cellEditorParams: {
      min: 1,
      max: 10,
      precision: 0
    },
    cellStyle: { textAlign: 'center', fontWeight: '600' }
  },
  {
    headerName: 'Status',
    field: 'status',
    editable: true,
    width: 150,
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
    headerName: 'Stage',
    field: 'stage',
    editable: true,
    width: 140,
    cellEditor: 'agSelectCellEditor',
    cellEditorParams: {
      values: ['Planning', 'Execution', 'Review', 'Done']
    }
  },
  {
    headerName: 'Type',
    field: 'type',
    editable: true,
    width: 140
  },
  {
    headerName: 'Deadline',
    field: 'deadline',
    editable: true,
    width: 140,
    cellEditor: 'agDateStringCellEditor',
    valueFormatter: (params) => {
      if (!params.value) return ''
      const date = new Date(params.value)
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
    }
  },
  {
    headerName: 'SMART',
    field: 'smart',
    editable: true,
    width: 100,
    cellRenderer: (params: any) => {
      return params.value ? '✓ Yes' : '✗ No'
    },
    cellEditor: 'agCheckboxCellEditor'
  },
  {
    headerName: 'Actions',
    field: 'actions',
    editable: false,
    sortable: false,
    filter: false,
    width: 150,
    cellRenderer: (params: any) => {
      const container = document.createElement('div')
      container.style.display = 'flex'
      container.style.gap = '8px'
      container.style.alignItems = 'center'
      container.style.height = '100%'

      const viewBtn = document.createElement('button')
      viewBtn.innerHTML = '👁️ View'
      viewBtn.className = 'text-sm px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600'
      viewBtn.onclick = () => viewGoal(params.data._id)

      const deleteBtn = document.createElement('button')
      deleteBtn.innerHTML = '🗑️'
      deleteBtn.className = 'text-sm px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600'
      deleteBtn.onclick = () => deleteGoal(params.data._id)

      container.appendChild(viewBtn)
      container.appendChild(deleteBtn)
      return container
    }
  }
]

onMounted(() => {
  goalsStore.fetchGoals()
})

function onGridReady(params: GridReadyEvent) {
  gridApi.value = params.api
  params.api.sizeColumnsToFit()
}

async function onCellValueChanged(event: CellValueChangedEvent) {
  const updatedGoal = event.data as Goal

  if (!updatedGoal._id) return

  const updates: Partial<Goal> = {
    [event.column.getColId()]: event.newValue
  }

  const success = await goalsStore.updateGoal(updatedGoal._id, updates)

  if (!success) {
    event.node.setDataValue(event.column.getColId(), event.oldValue)
  }
}

async function addNewGoal() {
  const newGoalData = {
    goal: 'New Goal - Click to edit',
    priority: 'B' as 'A' | 'B' | 'C' | 'D',
    urgency: 5,
    deadline: new Date().toISOString().split('T')[0],
    type: 'General',
    status: 'Not Started',
    stage: 'Planning',
    smart: false
  }

  const created = await goalsStore.createGoal(newGoalData)

  if (created && gridApi.value) {
    setTimeout(() => {
      const rowIndex = goalsStore.goals.findIndex(g => g._id === created._id)
      if (rowIndex >= 0) {
        gridApi.value?.ensureIndexVisible(rowIndex)
        gridApi.value?.flashCells({ rowNodes: [gridApi.value.getRowNode(String(rowIndex))!] })
      }
    }, 100)
  }
}

async function deleteGoal(goalId: string) {
  if (confirm('Are you sure you want to delete this goal?')) {
    await goalsStore.deleteGoal(goalId)
  }
}

function viewGoal(goalId: string) {
  window.open(`/goals/${goalId}`, '_blank')
}
</script>

<style>
.ag-theme-alpine {
  --ag-borders: solid 1px #e5e7eb;
  --ag-row-hover-color: #f3f4f6;
  --ag-selected-row-background-color: #dbeafe;
  --ag-header-background-color: #f9fafb;
  --ag-header-foreground-color: #111827;
  --ag-odd-row-background-color: #ffffff;
  --ag-even-row-background-color: #f9fafb;
  --ag-font-size: 14px;
  --ag-font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
}

.ag-theme-alpine .ag-header-cell-label {
  font-weight: 600;
  color: #374151;
}

.ag-theme-alpine .ag-cell {
  display: flex;
  align-items: center;
}

.ag-theme-alpine .ag-cell-focus {
  border: 2px solid #3b82f6 !important;
}

.ag-theme-alpine .ag-cell-inline-editing {
  border: 2px solid #3b82f6 !important;
  background-color: #fff !important;
}

.ag-theme-alpine .ag-root-wrapper {
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  overflow: hidden;
}
</style>
