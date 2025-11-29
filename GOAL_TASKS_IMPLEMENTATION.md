# Goal-to-Tasks Implementation

## Overview

The Goal Detail page now displays all tasks associated with a goal using **AG Grid** for inline editing, along with a **visual progress tracker** showing completion percentage.

---

## ✅ Features Implemented

### 1. **Goal Details Card**
- Priority badge (color-coded A/B/C/D)
- Goal type badge
- Status, Stage, Deadline, SMART indicator
- Delete Goal button
- Created/Updated timestamps

### 2. **Progress Tracking**
- **Visual Progress Bar** with color gradient:
  - 0-25%: Red
  - 25-50%: Orange
  - 50-75%: Yellow
  - 75-100%: Blue
  - 100%: Green
- **Completion Count**: "X of Y tasks completed"
- **Percentage Display**: Real-time calculation

### 3. **Tasks AG Grid**
Fully editable data grid with inline editing:

| Column | Type | Options |
|--------|------|---------|
| **Task** | Text (multiline) | Editable |
| **Priority** | Dropdown | A, B, C, D (color-coded) |
| **Status** | Dropdown | Not Started, In Progress, On Hold, Completed, Cancelled |
| **Due Date** | Date Picker | Formatted display |
| **Assigned To** | Text | Optional field |
| **Actions** | Delete button | 🗑️ Remove task |

### 4. **Task Management**
- ✅ **View all tasks** for a goal
- ✅ **Add new task** with "+ New Task" button
- ✅ **Edit inline** - click any cell to edit
- ✅ **Auto-save** - changes sync to backend immediately
- ✅ **Delete task** with confirmation
- ✅ **Progress updates** automatically when task status changes

---

## 🎯 How It Works

### Progress Calculation

```typescript
function getTaskProgress(goalTasks: Task[]) {
  if (goalTasks.length === 0) return 0
  const completed = goalTasks.filter(t => t.status === 'Completed').length
  return Math.round((completed / goalTasks.length) * 100)
}
```

**Progress updates automatically when:**
- A task status is changed to "Completed"
- A task is added or deleted
- Tasks are loaded from the server

### API Integration

**Endpoints Used:**

```
GET  /api/tasks/goal/:goalId  - Fetch all tasks for a goal
POST /api/tasks/goal/:goalId  - Create new task
PUT  /api/tasks/:id           - Update task
DELETE /api/tasks/:id         - Delete task
```

**Auto-Sync Behavior:**
- Task edits trigger PUT request with changed field
- Failed updates rollback to previous value
- Progress recalculates after each change

---

## 📖 Usage Guide

### Viewing Goal with Tasks

1. Navigate to Goals page: http://localhost:8080/goals
2. Click on any goal (or use View button)
3. Goal detail page shows:
   - Goal information at top
   - Progress bar
   - Tasks grid below

### Adding a New Task

1. Click **"+ New Task"** button
2. A new row appears with default values
3. Click any cell to edit:
   - Task name
   - Priority
   - Status
   - Due date
   - Assigned to
4. Changes save automatically

### Editing Tasks Inline

1. **Click any cell** in the grid
2. **Modify the value**:
   - Text: Type your changes
   - Dropdown: Select option
   - Date: Use date picker
3. **Press Enter** or **click outside** to save
4. Progress bar updates automatically

### Tracking Progress

- **Progress Bar** fills as tasks are completed
- **Color changes** based on completion percentage
- **Count displays**: "X of Y tasks completed"
- Mark task as "Completed" to update progress

### Deleting a Task

1. Click the **🗑️** button in Actions column
2. Confirm deletion
3. Task removed, progress recalculates

---

## 🎨 Visual Features

### Progress Bar Colors

| Progress | Color | Meaning |
|----------|-------|---------|
| 0-24% | Red | Just started |
| 25-49% | Orange | Making progress |
| 50-74% | Yellow | Halfway there |
| 75-99% | Blue | Almost done |
| 100% | Green | Complete! |

### Priority Color Coding

| Priority | Color | Badge |
|----------|-------|-------|
| A | Red | High urgency |
| B | Yellow | Medium |
| C | Blue | Low |
| D | Gray | Someday |

### Status Color Coding

| Status | Color | Meaning |
|--------|-------|---------|
| Not Started | Gray | Haven't begun |
| In Progress | Blue | Currently working |
| On Hold | Yellow | Paused |
| Completed | Green | Done! |
| Cancelled | Red | Won't do |

---

## 🛠️ Technical Implementation

### Files Created/Modified

```
frontend/src/stores/tasks.ts (NEW)
  - Pinia store for tasks
  - CRUD operations
  - Progress calculation

frontend/src/views/goals/GoalDetailView.vue (UPDATED)
  - AG Grid integration for tasks
  - Progress bar component
  - Auto-save functionality

frontend/src/types/index.ts (EXISTS)
  - Task interface already defined
```

### Task Store Functions

```typescript
// Fetch tasks for a goal
async function fetchTasksByGoal(goalId: string)

// Create new task
async function createTask(taskData: Partial<Task>)

// Update task (single field or multiple)
async function updateTask(id: string, taskData: Partial<Task>)

// Delete task
async function deleteTask(id: string)

// Calculate progress percentage
function getTaskProgress(goalTasks: Task[])
```

### Column Configuration

```typescript
const columnDefs: ColDef[] = [
  {
    headerName: 'Task',
    field: 'task',
    editable: true,
    flex: 2
  },
  {
    headerName: 'Priority',
    field: 'priority',
    cellEditor: 'agSelectCellEditor',
    cellEditorParams: { values: ['A', 'B', 'C', 'D'] }
  },
  {
    headerName: 'Status',
    field: 'status',
    cellEditor: 'agSelectCellEditor',
    cellEditorParams: {
      values: ['Not Started', 'In Progress', 'On Hold', 'Completed', 'Cancelled']
    }
  }
  // ... more columns
]
```

---

## 🔄 Data Flow

```
1. User navigates to Goal Detail
   ↓
2. GoalDetailView loads goal data
   ↓
3. Fetch tasks for goal (fetchTasksByGoal)
   ↓
4. Display tasks in AG Grid
   ↓
5. Calculate and show progress
   ↓
6. User edits cell → onCellValueChanged
   ↓
7. Update API call (updateTask)
   ↓
8. On success: Update store → Progress recalculates
   ↓
9. On failure: Rollback to previous value
```

---

## 📊 Progress Bar Implementation

```vue
<template>
  <div class="mb-6">
    <div class="flex justify-between items-center mb-2">
      <p class="text-sm font-semibold">Progress</p>
      <p class="text-sm font-bold text-primary-600">{{ progress }}%</p>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-4">
      <div
        class="h-full rounded-full transition-all duration-500"
        :class="getProgressColor(progress)"
        :style="{ width: progress + '%' }"
      ></div>
    </div>
    <p class="text-xs text-gray-500 mt-1">
      {{ completedTasksCount }} of {{ totalTasksCount }} tasks completed
    </p>
  </div>
</template>
```

---

## 🧪 Testing

### Manual Test Scenarios

1. **View Goal with Tasks**
   - ✅ Navigate to goal detail
   - ✅ Tasks grid displays
   - ✅ Progress bar shows correct percentage

2. **Add New Task**
   - ✅ Click "+ New Task"
   - ✅ New row appears
   - ✅ Edit inline
   - ✅ Changes save

3. **Edit Task Inline**
   - ✅ Click cell
   - ✅ Modify value
   - ✅ Auto-saves

4. **Update Progress**
   - ✅ Mark task as "Completed"
   - ✅ Progress bar updates
   - ✅ Color changes

5. **Delete Task**
   - ✅ Click delete button
   - ✅ Confirm
   - ✅ Task removed
   - ✅ Progress recalculates

### API Test

```bash
# Get tasks for a goal
TOKEN=$(curl -s -X POST http://localhost:3000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@tms.dev","password":"password"}' | jq -r '.data.token')

GOAL_ID="692a7016bd50b83d02725c72"

# Fetch tasks
curl -H "Authorization: Bearer $TOKEN" \
  http://localhost:3000/api/tasks/goal/$GOAL_ID | jq

# Create task
curl -X POST -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"task":"New task","priority":"A","status":"Not Started","duedate":"2025-12-31"}' \
  http://localhost:3000/api/tasks/goal/$GOAL_ID | jq
```

---

## 🎯 Key Features Summary

| Feature | Status | Description |
|---------|--------|-------------|
| View Tasks | ✅ | AG Grid display with all task fields |
| Add Task | ✅ | "+ New Task" button, inline editing |
| Edit Task | ✅ | Click cell to edit, auto-save |
| Delete Task | ✅ | Delete button with confirmation |
| Progress Bar | ✅ | Visual indicator with percentage |
| Color Coding | ✅ | Priority and status colors |
| Auto-Sync | ✅ | Changes save to backend |
| Rollback | ✅ | Failed updates revert |

---

## 🔮 Future Enhancements

Potential improvements:

1. **Subtasks**: Add subtask grid for each task
2. **Task Dependencies**: Link tasks with prerequisites
3. **Time Tracking**: Track time spent on tasks
4. **Comments**: Add notes/comments to tasks
5. **Attachments**: Upload files to tasks
6. **Filters**: Filter tasks by status/priority
7. **Bulk Actions**: Select multiple tasks for updates
8. **Due Date Alerts**: Highlight overdue tasks

---

## 📚 Related Documentation

- [AG_GRID_IMPLEMENTATION.md](AG_GRID_IMPLEMENTATION.md) - AG Grid setup for Goals
- [AG_GRID_SUMMARY.md](AG_GRID_SUMMARY.md) - AG Grid quick reference
- [backend/README.md](backend/README.md) - API documentation

---

## 🎉 Benefits

**Before:**
- No task tracking for goals
- No progress visualization
- Manual status updates

**After:**
- Full task management per goal
- Visual progress tracking
- Inline editing with auto-save
- Real-time progress updates
- Professional AG Grid interface

---

**Version**: 1.0.0
**Implemented**: November 29, 2025
**Status**: ✅ Production Ready

Access: http://localhost:8080/goals → Click any goal to see tasks
