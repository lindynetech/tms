# TMS Frontend - Vue 3 SPA

Modern Vue 3 Single Page Application for TMS (Time Management System).

## Tech Stack

- **Vue 3** with Composition API
- **TypeScript** for type safety
- **Vite** for blazing fast development
- **Vue Router** for routing
- **Pinia** for state management
- **Tailwind CSS** for styling
- **Axios** for API calls
- **date-fns** for date formatting

## Features

- ✅ JWT Authentication
- ✅ Goals Management
- ✅ Dashboard with Quick Actions
- ✅ Responsive Design
- ✅ Type-safe API Layer
- ✅ Protected Routes
- 🚧 Daily Goals (coming soon)
- 🚧 Habits Tracking (coming soon)
- 🚧 Reading List (coming soon)
- 🚧 Mindstorms (coming soon)
- 🚧 Vendors Management (coming soon)

## Quick Start

### Development

```bash
cd frontend
npm install
npm run dev
```

Access at: http://localhost:5173

### Production Build

```bash
npm run build
npm run preview
```

### With Docker

```bash
cd /home/deploy/Work/CICD/ops-apps/tms
docker compose -f docker-compose.backend.yml up -d
```

Access at: http://localhost:8080

## Project Structure

```
frontend/
├── src/
│   ├── assets/           # Static assets
│   ├── components/       # Reusable components
│   ├── config/           # Configuration files
│   ├── layouts/          # Layout components
│   ├── router/           # Vue Router configuration
│   ├── services/         # API services
│   ├── stores/           # Pinia stores
│   ├── types/            # TypeScript types
│   ├── views/            # Page components
│   ├── App.vue           # Root component
│   ├── main.ts           # Application entry
│   └── style.css         # Global styles
├── public/               # Public static files
├── index.html            # HTML template
├── package.json          # Dependencies
├── vite.config.ts        # Vite configuration
├── tailwind.config.js    # Tailwind CSS config
└── tsconfig.json         # TypeScript config
```

## Environment Variables

Create a `.env` file:

```env
VITE_API_URL=http://localhost:3000/api
VITE_APP_NAME=TMS
```

## Default Credentials

- **Email**: `admin@tms.dev`
- **Password**: `password`

## API Integration

The frontend connects to the Node.js backend API at `http://localhost:3000/api`.

### Key Services

- **auth.service.ts** - Authentication (login, register, logout)
- **api.ts** - Axios instance with JWT interceptors

### Pinia Stores

- **auth** - User authentication state
- **goals** - Goals management state

## Development

### Coding Standards

- Use Composition API with `<script setup>`
- TypeScript for all new code
- Tailwind CSS for styling
- Component names in PascalCase
- Follow Vue 3 best practices

### Adding New Features

1. Create types in `src/types/index.ts`
2. Create API service in `src/services/`
3. Create Pinia store in `src/stores/`
4. Create views in `src/views/`
5. Add routes in `src/router/index.ts`

## Available Scripts

```bash
npm run dev          # Start development server
npm run build        # Build for production
npm run preview      # Preview production build
npm run lint         # Lint code
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## License

Proprietary - All rights reserved

---

**Built with Vue 3 • TypeScript • Vite • Tailwind CSS**
