export interface User {
  id: string
  name: string
  email: string
}

export interface Goal {
  _id: string
  userId: string
  goal: string
  priority: 'A' | 'B' | 'C' | 'D'
  urgency: number
  deadline: string
  status: string
  stage: string
  smart: boolean
  type: string
  createdAt: string
  updatedAt: string
}

export interface Task {
  _id: string
  goalId: string
  task: string
  status: string
  priority: 'A' | 'B' | 'C' | 'D'
  duedate: string
  assignedTo?: string
  createdAt: string
  updatedAt: string
}

export interface Subtask {
  _id: string
  taskId: string
  subtask: string
  status: string
  createdAt: string
  updatedAt: string
}

export interface DailyGoal {
  _id: string
  userId: string
  goal: string
  priority: 'A' | 'B' | 'C' | 'D'
  urgency: number
  deadline: string
  type: string
  createdAt: string
  updatedAt: string
}

export interface Habit {
  _id: string
  userId: string
  habit: string
  frequency: string
  streak: number
  longestStreak: number
  startDate: string
  active: boolean
  createdAt: string
  updatedAt: string
}

export interface HabitDay {
  _id: string
  habitId: string
  date: string
  completed: boolean
  notes?: string
  createdAt: string
  updatedAt: string
}

export interface Mindstorm {
  _id: string
  userId: string
  question: string
  category: string
  active: boolean
  createdAt: string
  updatedAt: string
}

export interface MindstormIdea {
  _id: string
  mindstormId: string
  idea: string
  rating?: number
  implemented: boolean
  createdAt: string
  updatedAt: string
}

export interface ReadingListItem {
  _id: string
  userId: string
  title: string
  author?: string
  type: string
  status: string
  priority: 'A' | 'B' | 'C' | 'D'
  startDate?: string
  completionDate?: string
  rating?: number
  createdAt: string
  updatedAt: string
}

export interface ReadingListNote {
  _id: string
  readingListId: string
  note: string
  page?: number
  chapter?: string
  createdAt: string
  updatedAt: string
}

export interface Vendor {
  _id: string
  userId: string
  name: string
  email?: string
  phone?: string
  company?: string
  role?: string
  notes?: string
  active: boolean
  createdAt: string
  updatedAt: string
}

export interface ApiResponse<T> {
  status: string
  data: T
  message?: string
}
