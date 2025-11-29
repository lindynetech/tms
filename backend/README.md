# TMS Backend - Node.js/Express/MongoDB

Modern Node.js backend for TMS (Time Management System), built with Express.js, TypeScript, and MongoDB.

## Tech Stack

- **Runtime**: Node.js 20+
- **Framework**: Express.js 4.x
- **Language**: TypeScript 5.x
- **Database**: MongoDB 8.0 with Mongoose ODM
- **Authentication**: JWT (JSON Web Tokens)
- **Validation**: Joi
- **Cache**: Redis 7
- **Containerization**: Docker & Docker Compose

## Features

- ✅ RESTful API with Express.js
- ✅ MongoDB with Mongoose schemas
- ✅ JWT-based authentication
- ✅ Request validation with Joi
- ✅ Error handling middleware
- ✅ Database migrations support
- ✅ Docker containerization
- ✅ TypeScript for type safety
- ✅ ESM modules support
- ✅ Rate limiting
- ✅ CORS enabled
- ✅ Security headers (Helmet)

## API Endpoints

### Authentication
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login user
- `POST /api/auth/logout` - Logout user
- `POST /api/auth/refresh-token` - Refresh access token
- `GET /api/auth/me` - Get current user

### Goals
- `GET /api/goals` - List all goals
- `POST /api/goals` - Create goal
- `GET /api/goals/:id` - Get single goal
- `PUT /api/goals/:id` - Update goal
- `DELETE /api/goals/:id` - Delete goal

### Tasks
- `GET /api/tasks/goal/:goalId` - List tasks for goal
- `POST /api/tasks/goal/:goalId` - Create task
- `GET /api/tasks/:id` - Get single task
- `PUT /api/tasks/:id` - Update task
- `DELETE /api/tasks/:id` - Delete task
- `GET /api/tasks/:taskId/subtasks` - List subtasks
- `POST /api/tasks/:taskId/subtasks` - Create subtask
- `PUT /api/tasks/subtasks/:id` - Update subtask
- `DELETE /api/tasks/subtasks/:id` - Delete subtask

### Daily Goals
- `GET /api/daily-goals` - List daily goals
- `POST /api/daily-goals` - Create daily goal
- `PUT /api/daily-goals/:id` - Update daily goal
- `DELETE /api/daily-goals/:id` - Delete daily goal
- `DELETE /api/daily-goals` - Flush all daily goals

### Habits
- `GET /api/habits` - List habits
- `POST /api/habits` - Create habit
- `GET /api/habits/:id` - Get habit with tracking
- `PUT /api/habits/:id` - Update habit
- `DELETE /api/habits/:id` - Delete habit
- `POST /api/habits/:habitId/track` - Track habit for a day
- `POST /api/habits/:id/reset` - Reset habit streak

### Mindstorms
- `GET /api/mindstorms` - List mindstorms
- `POST /api/mindstorms` - Create mindstorm
- `GET /api/mindstorms/:id` - Get mindstorm with ideas
- `PUT /api/mindstorms/:id` - Update mindstorm
- `DELETE /api/mindstorms/:id` - Delete mindstorm
- `POST /api/mindstorms/:mindstormId/ideas` - Create idea
- `PUT /api/mindstorms/ideas/:ideaId` - Update idea
- `DELETE /api/mindstorms/ideas/:ideaId` - Delete idea

### Reading List
- `GET /api/reading-list` - List reading items
- `POST /api/reading-list` - Create reading item
- `GET /api/reading-list/:id` - Get item with notes
- `PUT /api/reading-list/:id` - Update item
- `DELETE /api/reading-list/:id` - Delete item
- `POST /api/reading-list/:itemId/notes` - Create note
- `PUT /api/reading-list/notes/:noteId` - Update note
- `DELETE /api/reading-list/notes/:noteId` - Delete note

### Vendors
- `GET /api/vendors` - List vendors
- `POST /api/vendors` - Create vendor
- `GET /api/vendors/:id` - Get vendor
- `PUT /api/vendors/:id` - Update vendor
- `DELETE /api/vendors/:id` - Delete vendor

### Profile
- `GET /api/profile` - Get user profile
- `PUT /api/profile` - Update profile
- `POST /api/profile/change-password` - Change password

## Quick Start

### Prerequisites

- Node.js 20+
- npm 10+
- Docker & Docker Compose (recommended)

### Installation

**Option 1: Using Docker (Recommended)**

```bash
cd backend
cp .env.example .env
cd ..
docker-compose -f docker-compose.backend.yml up -d
```

Access the API at: http://localhost:3000

**Option 2: Local Development**

```bash
cd backend
npm install
cp .env.example .env
# Update .env with your local MongoDB connection
npm run dev
```

### Initial Setup

1. **Seed the database:**

```bash
# Using Docker
docker-compose -f docker-compose.backend.yml exec backend npm run seed

# Local
npm run seed
```

2. **Default credentials:**
   - Email: `admin@tms.dev`
   - Password: `password`

## Development

### Available Scripts

```bash
npm run dev          # Start development server with hot reload
npm run build        # Build TypeScript to JavaScript
npm start            # Start production server
npm run seed         # Seed database with sample data
npm test             # Run tests
npm run lint         # Lint code
npm run format       # Format code with Prettier
```

### Database Migrations

```bash
# Create a new migration
npm run migrate:create <migration-name>

# Run pending migrations
npm run migrate:up

# Rollback last migration
npm run migrate:down

# Check migration status
npm run migrate:status
```

### Environment Variables

Create a `.env` file:

```env
NODE_ENV=development
PORT=3000

MONGODB_URI=mongodb://tms:secret@mongodb:27017/tms?authSource=admin
JWT_SECRET=your-super-secret-jwt-key
JWT_EXPIRES_IN=7d

REDIS_HOST=redis
REDIS_PORT=6379

CORS_ORIGIN=http://localhost:5173,http://localhost:8080
```

## Migration from Laravel

### Migrate Data from MySQL to MongoDB

```bash
# Set MySQL connection environment variables
export MYSQL_HOST=localhost
export MYSQL_PORT=3306
export MYSQL_USER=tms
export MYSQL_PASSWORD=secret
export MYSQL_DATABASE=tms

# Run migration script
npm run migrate-from-mysql
```

### Key Differences from Laravel

| Laravel | Node.js Backend |
|---------|-----------------|
| Eloquent ORM | Mongoose ODM |
| `.env` | `.env` |
| `php artisan migrate` | `npm run migrate:up` |
| `php artisan db:seed` | `npm run seed` |
| `php artisan serve` | `npm run dev` |
| Routes in `routes/web.php` | Routes in `src/routes/*.routes.ts` |
| Controllers in `app/Http/Controllers` | Controllers in `src/controllers/*.controller.ts` |
| Models in `app/` | Models in `src/models/*.ts` |
| Middleware in `app/Http/Middleware` | Middleware in `src/middleware/*.ts` |

## Docker Services

| Service | Container | Port | Purpose |
|---------|-----------|------|---------|
| **Backend** | tms-backend | 3000 | Node.js API |
| **MongoDB** | tms-mongodb | 27017 | Database |
| **Redis** | tms-redis | 6380→6379 | Cache & sessions |
| **Mailpit** | tms-mailpit | 8025, 1025 | Email testing |

### Docker Commands

```bash
# Start all services
docker-compose -f docker-compose.backend.yml up -d

# View logs
docker-compose -f docker-compose.backend.yml logs -f backend

# Stop services
docker-compose -f docker-compose.backend.yml down

# Rebuild
docker-compose -f docker-compose.backend.yml up -d --build

# Shell access
docker-compose -f docker-compose.backend.yml exec backend sh
```

## Project Structure

```
backend/
├── src/
│   ├── config/              # Configuration files
│   │   ├── app.ts          # App configuration
│   │   └── database.ts     # Database connection
│   ├── controllers/         # Request handlers
│   │   ├── auth.controller.ts
│   │   ├── goal.controller.ts
│   │   └── ...
│   ├── models/             # Mongoose models
│   │   ├── User.ts
│   │   ├── Goal.ts
│   │   └── ...
│   ├── routes/             # API routes
│   │   ├── auth.routes.ts
│   │   ├── goal.routes.ts
│   │   └── ...
│   ├── middleware/         # Express middleware
│   │   ├── auth.ts
│   │   ├── validate.ts
│   │   └── errorHandler.ts
│   ├── database/           # Database related
│   │   ├── migrations/     # Migration files
│   │   └── seeders/        # Seed scripts
│   └── server.ts           # Application entry point
├── scripts/                # Utility scripts
│   └── migrate-mysql-to-mongo.ts
├── dist/                   # Compiled JavaScript (generated)
├── package.json
├── tsconfig.json
├── Dockerfile
└── README.md
```

## Testing

```bash
# Run all tests
npm test

# Run tests in watch mode
npm run test:watch

# Generate coverage report
npm run test:coverage
```

## Production Deployment

1. **Build the application:**

```bash
npm run build
```

2. **Set production environment variables:**

```env
NODE_ENV=production
PORT=3000
MONGODB_URI=mongodb://user:pass@host:port/db
JWT_SECRET=strong-random-secret
```

3. **Start the server:**

```bash
npm start
```

4. **Using Docker:**

```bash
docker build -t tms-backend .
docker run -p 3000:3000 --env-file .env tms-backend
```

## Security

- JWT authentication for all protected routes
- Password hashing with bcrypt
- Helmet.js for security headers
- Rate limiting to prevent abuse
- CORS configuration
- Input validation with Joi
- MongoDB injection protection via Mongoose

## Performance

- MongoDB indexing on frequently queried fields
- Redis caching for sessions
- Compression middleware
- Connection pooling
- Async/await for non-blocking operations

## Troubleshooting

### MongoDB Connection Issues

```bash
# Check if MongoDB is running
docker-compose -f docker-compose.backend.yml ps

# View MongoDB logs
docker-compose -f docker-compose.backend.yml logs mongodb

# Connect to MongoDB shell
docker-compose -f docker-compose.backend.yml exec mongodb mongosh -u tms -p secret
```

### Port Already in Use

```bash
# Find process using port 3000
lsof -ti:3000

# Kill the process
kill -9 $(lsof -ti:3000)
```

### Clear All Data and Restart

```bash
docker-compose -f docker-compose.backend.yml down -v
docker-compose -f docker-compose.backend.yml up -d
npm run seed
```

## Contributing

1. Create feature branch
2. Make changes
3. Run tests and linter
4. Submit pull request

## License

Proprietary - All rights reserved

---

**Built with Node.js • Express.js • TypeScript • MongoDB • Docker**
