# TMS Quick Start Guide

## 🚀 Start the Application

### Method 1: Using Docker Compose (Recommended)

```bash
cd /home/deploy/Work/CICD/ops-apps/tms

# Start all services
docker compose -f docker-compose.backend.yml up -d

# Check status
docker compose -f docker-compose.backend.yml ps

# View logs
docker compose -f docker-compose.backend.yml logs -f backend
docker compose -f docker-compose.backend.yml logs -f frontend
```

### Method 2: Using the Helper Script

```bash
cd /home/deploy/Work/CICD/ops-apps/tms/backend
chmod +x scripts/start.sh
./scripts/start.sh
```

---

## 🌐 Access the Application

| Service | URL | Credentials |
|---------|-----|-------------|
| **Frontend (Vue 3)** | http://localhost:8080 | admin@tms.dev / password |
| **Backend API** | http://localhost:3000 | - |
| **API Health Check** | http://localhost:3000/health | - |
| **Mailpit UI** | http://localhost:8025 | - |
| **MongoDB** | mongodb://localhost:27017 | tms / secret |
| **Redis** | localhost:6380 | - |

---

## 🧪 Test the Application

### API Tests

```bash
# Health check
curl http://localhost:3000/health

# Login and get token
TOKEN=$(curl -s -X POST http://localhost:3000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@tms.dev","password":"password"}' | jq -r '.data.token')

echo $TOKEN

# Get goals
curl -H "Authorization: Bearer $TOKEN" http://localhost:3000/api/goals | jq
```

### Frontend Test

1. Open browser to http://localhost:8080
2. Login with: admin@tms.dev / password
3. Navigate through the application

---

## 🛑 Stop the Application

```bash
# Stop all services
docker compose -f docker-compose.backend.yml down

# Stop and remove volumes (will delete all data)
docker compose -f docker-compose.backend.yml down -v
```

---

## 🔄 Restart Services

```bash
# Restart all services
docker compose -f docker-compose.backend.yml restart

# Restart specific service
docker compose -f docker-compose.backend.yml restart backend
docker compose -f docker-compose.backend.yml restart frontend
```

---

## 📊 View Logs

```bash
# All services
docker compose -f docker-compose.backend.yml logs -f

# Specific service
docker compose -f docker-compose.backend.yml logs -f backend
docker compose -f docker-compose.backend.yml logs -f frontend
docker compose -f docker-compose.backend.yml logs -f mongodb
```

---

## 🗄️ Database Management

### Access MongoDB Shell

```bash
docker compose -f docker-compose.backend.yml exec mongodb mongosh \
  mongodb://tms:secret@localhost:27017/tms?authSource=admin
```

### Run Migrations

```bash
docker compose -f docker-compose.backend.yml exec backend npm run migrate:up
```

### Seed Database

```bash
docker compose -f docker-compose.backend.yml exec backend npm run seed
```

---

## 🐛 Troubleshooting

### Ports Already in Use

```bash
# Check what's using the ports
lsof -ti:8080  # Frontend
lsof -ti:3000  # Backend
lsof -ti:27017 # MongoDB

# Kill processes if needed
kill $(lsof -ti:8080)
```

### Reset Everything

```bash
# Stop and remove all containers, networks, and volumes
docker compose -f docker-compose.backend.yml down -v

# Remove images
docker rmi tms-backend tms-frontend

# Rebuild and start fresh
docker compose -f docker-compose.backend.yml up -d --build
```

### View Container Status

```bash
# Check if containers are running
docker ps | grep tms

# Check container health
docker inspect tms-backend | jq '.[0].State.Health'
```

### Common Issues

**Frontend shows 502 Bad Gateway:**
- Backend might not be ready yet. Wait 10-15 seconds after starting.

**Database connection failed:**
- Check MongoDB is running: `docker compose -f docker-compose.backend.yml ps mongodb`
- Check logs: `docker compose -f docker-compose.backend.yml logs mongodb`

**API returns 401 Unauthorized:**
- JWT token might be expired. Login again to get a new token.

---

## 📦 Development Mode

### Backend Development

```bash
cd /home/deploy/Work/CICD/ops-apps/tms/backend

# Install dependencies
npm install

# Start in watch mode (outside Docker)
npm run dev

# Build
npm run build

# Lint
npm run lint
```

### Frontend Development

```bash
cd /home/deploy/Work/CICD/ops-apps/tms/frontend

# Install dependencies
npm install

# Start dev server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

---

## 📚 Additional Documentation

- [Backend README](backend/README.md) - Backend API documentation
- [Frontend README](frontend/README.md) - Frontend development guide
- [Migration Guide](MIGRATION_GUIDE.md) - Complete migration documentation
- [Test Results](TEST_RESULTS.md) - Comprehensive test results
- [Complete Summary](COMPLETE_MIGRATION_SUMMARY.md) - Full migration summary

---

## 🎯 Default Users

| Email | Password | Role |
|-------|----------|------|
| admin@tms.dev | password | Admin |

---

## 🔐 Environment Variables

### Backend (.env)

Located at: `backend/.env`

```env
NODE_ENV=production
PORT=3000
MONGODB_URI=mongodb://tms:secret@mongodb:27017/tms?authSource=admin
JWT_SECRET=your-super-secret-jwt-key-change-in-production
JWT_EXPIRES_IN=7d
REDIS_HOST=redis
REDIS_PORT=6379
MAIL_HOST=mailpit
MAIL_PORT=1025
```

### Frontend (.env)

Located at: `frontend/.env`

```env
VITE_API_URL=http://localhost:3000/api
VITE_APP_NAME=TMS
```

---

## ✅ Health Checks

```bash
# Backend health
curl http://localhost:3000/health

# Expected response:
# {
#   "status": "ok",
#   "mongodb": "connected",
#   "timestamp": "2025-11-29T..."
# }

# Frontend health
curl -I http://localhost:8080

# Expected: HTTP/1.1 200 OK
```

---

## 🎉 You're Ready!

The TMS application is now running. Open http://localhost:8080 in your browser and start managing your time!

**Need help?** Check the documentation in the links above or review the logs for any errors.
