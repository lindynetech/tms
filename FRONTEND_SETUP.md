# Vue 3 Frontend Setup Guide

Complete guide for the new Vue 3 SPA frontend connected to Node.js backend.

## ✅ What's New

- **Complete Vue 3 rewrite** - No Laravel dependencies
- **TypeScript** throughout for type safety
- **JWT Authentication** - Token-based, not sessions
- **Modern Tech Stack** - Vue 3, Vite, Pinia, Tailwind CSS
- **API-First Design** - Clean separation from backend
- **Responsive UI** - Mobile-friendly interface

## 🚀 Quick Start

### Option 1: With Docker (Recommended)

```bash
cd /home/deploy/Work/CICD/ops-apps/tms

# Start all services (backend + frontend + databases)
docker compose -f docker-compose.backend.yml up -d --build

# Frontend will be available at:
http://localhost:8080

# Backend API at:
http://localhost:3000
```

### Option 2: Local Development

```bash
# Start backend first (in one terminal)
cd backend
npm install
npm run dev

# Start frontend (in another terminal)
cd frontend
npm install
npm run dev
```

**Access:**
- Frontend: http://localhost:5173
- Backend API: http://localhost:3000

## 📁 Project Structure

```
tms/
├── frontend/           # NEW: Vue 3 SPA
│   ├── src/
│   │   ├── views/      # Page components
│   │   ├── stores/     # Pinia state management
│   │   ├── services/   # API services
│   │   ├── router/     # Vue Router
│   │   └── types/      # TypeScript definitions
│   └── package.json
│
├── backend/            # Node.js API
│   └── src/...
│
└── docker-compose.backend.yml  # All services
```

## 🔑 Default Login

- **Email**: `admin@tms.dev`
- **Password**: `password`

## ✨ Features Implemented

### ✅ Fully Functional

1. **Authentication**
   - Login/Register pages
   - JWT token management
   - Protected routes
   - Auto-redirect on auth

2. **Dashboard**
   - Statistics cards
   - Recent goals
   - Quick action buttons

3. **Goals Management**
   - Create goals with full details
   - View all goals in cards
   - Goal detail page
   - Delete goals
   - Priority indicators

4. **Navigation**
   - Sidebar navigation
   - Route protection
   - User info display
   - Logout functionality

### 🚧 Placeholder Pages (Basic UI)

These pages have basic layout but need full implementation:

- Daily Goals
- Habits Tracking
- Mindstorms (Brainstorming)
- Reading List
- Vendors Management
- Profile Settings

## 🎨 Design System

### Colors

- **Primary**: Blue (#3b82f6)
- **Success**: Green
- **Warning**: Yellow
- **Danger**: Red

### Components

Reusable classes via Tailwind:

```html
<!-- Buttons -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-danger">Danger</button>

<!-- Cards -->
<div class="card">Content</div>

<!-- Forms -->
<label class="label">Label</label>
<input class="input" />
```

## 🔧 Configuration

### API Endpoint

Update in `frontend/.env`:

```env
VITE_API_URL=http://localhost:3000/api
```

### Vite Proxy

Development proxy configured in `vite.config.ts`:

```typescript
server: {
  proxy: {
    '/api': {
      target: 'http://localhost:3000',
      changeOrigin: true
    }
  }
}
```

## 📡 API Integration

### Authentication Flow

```typescript
// 1. Login
const response = await authService.login({ email, password })

// 2. Store token
localStorage.setItem('token', response.data.token)

// 3. Auto-attach to requests
axios.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  config.headers.Authorization = `Bearer ${token}`
  return config
})

// 4. Handle 401 errors
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      // Redirect to login
    }
  }
)
```

### Adding New API Calls

1. **Define types** in `src/types/index.ts`:

```typescript
export interface MyFeature {
  id: string
  name: string
  // ...
}
```

2. **Create service** in `src/services/`:

```typescript
import api from './api'

export const myService = {
  async getAll() {
    const response = await api.get('/my-feature')
    return response.data
  }
}
```

3. **Create Pinia store** in `src/stores/`:

```typescript
export const useMyStore = defineStore('my-feature', () => {
  const items = ref([])

  async function fetchItems() {
    const data = await myService.getAll()
    items.value = data
  }

  return { items, fetchItems }
})
```

4. **Use in component**:

```vue
<script setup lang="ts">
import { onMounted } from 'vue'
import { useMyStore } from '@/stores/myFeature'

const store = useMyStore()

onMounted(() => {
  store.fetchItems()
})
</script>
```

## 🐳 Docker Details

### Services

| Service | Port | Purpose |
|---------|------|---------|
| frontend | 8080 | Vue 3 SPA (Nginx) |
| backend | 3000 | Node.js API |
| mongodb | 27017 | Database |
| redis | 6380 | Cache |
| mailpit | 8025 | Email testing |

### Commands

```bash
# Start all
docker compose -f docker-compose.backend.yml up -d

# Rebuild frontend
docker compose -f docker-compose.backend.yml up -d --build frontend

# View logs
docker compose -f docker-compose.backend.yml logs -f frontend

# Stop all
docker compose -f docker-compose.backend.yml down
```

## 🔍 Troubleshooting

### Frontend won't connect to backend

1. Check backend is running:
```bash
curl http://localhost:3000/health
```

2. Check CORS settings in backend `src/server.ts`

3. Verify `.env` has correct `VITE_API_URL`

### Build errors

```bash
cd frontend
rm -rf node_modules dist
npm install
npm run build
```

### Docker issues

```bash
# Rebuild from scratch
docker compose -f docker-compose.backend.yml down -v
docker compose -f docker-compose.backend.yml up -d --build
```

## 📝 Next Steps

To fully implement remaining features:

1. **Daily Goals** - Create full CRUD UI
2. **Habits** - Add streak tracking and calendar view
3. **Reading List** - Implement with notes
4. **Mindstorms** - Build idea capture interface
5. **Vendors** - Complete contact management
6. **Profile** - Add password change, email update

Each feature needs:
- API service in `src/services/`
- Pinia store in `src/stores/`
- Full view in `src/views/`

## 🎯 Development Workflow

1. Start backend: `cd backend && npm run dev`
2. Start frontend: `cd frontend && npm run dev`
3. Make changes - hot reload works automatically
4. Test in browser at http://localhost:5173
5. Build for production: `npm run build`

## 📚 Resources

- [Vue 3 Docs](https://vuejs.org/)
- [Vite Docs](https://vitejs.dev/)
- [Pinia Docs](https://pinia.vuejs.org/)
- [Vue Router](https://router.vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/)

---

**Frontend is now 100% Laravel-free and connected to Node.js backend!** 🎉
