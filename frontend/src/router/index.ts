import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes: RouteRecordRaw[] = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/auth/LoginView.vue'),
    meta: { requiresGuest: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('@/views/auth/RegisterView.vue'),
    meta: { requiresGuest: true }
  },
  {
    path: '/',
    component: () => import('@/layouts/MainLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: () => import('@/views/DashboardView.vue')
      },
      {
        path: '/goals',
        name: 'Goals',
        component: () => import('@/views/goals/GoalsView.vue')
      },
      {
        path: '/goals/:id',
        name: 'GoalDetail',
        component: () => import('@/views/goals/GoalDetailView.vue')
      },
      {
        path: '/daily-goals',
        name: 'DailyGoals',
        component: () => import('@/views/DailyGoalsView.vue')
      },
      {
        path: '/habits',
        name: 'Habits',
        component: () => import('@/views/HabitsView.vue')
      },
      {
        path: '/mindstorms',
        name: 'Mindstorms',
        component: () => import('@/views/MindstormsView.vue')
      },
      {
        path: '/reading-list',
        name: 'ReadingList',
        component: () => import('@/views/ReadingListView.vue')
      },
      {
        path: '/vendors',
        name: 'Vendors',
        component: () => import('@/views/VendorsView.vue')
      },
      {
        path: '/profile',
        name: 'Profile',
        component: () => import('@/views/ProfileView.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, _from, next) => {
  const authStore = useAuthStore()

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  } else if (to.meta.requiresGuest && authStore.isAuthenticated) {
    next('/')
  } else {
    next()
  }
})

export default router
