# Laravel to Node.js Migration Guide

Complete guide for migrating the TMS application from Laravel/MySQL to Node.js/MongoDB.

## Overview

This migration transforms the TMS backend from:
- **Laravel 12 + PHP 8.4** → **Express.js + Node.js 20 + TypeScript**
- **MySQL 8.0** → **MongoDB 8.0**
- **Eloquent ORM** → **Mongoose ODM**

## Why This Stack?

### Backend: Express.js + TypeScript
- **Most Popular**: Largest ecosystem in Node.js
- **Flexible**: Perfect for RESTful APIs and SPAs
- **Type Safety**: TypeScript prevents runtime errors
- **Performance**: Non-blocking I/O, excellent for I/O-heavy apps
- **Easy Learning**: JavaScript everywhere (frontend + backend)

### Database: MongoDB + Mongoose
- **Schema Flexibility**: Easy to evolve data models
- **JSON Native**: Perfect for JavaScript/TypeScript
- **Horizontal Scaling**: Excellent for growing applications
- **Rich Queries**: Powerful aggregation framework
- **Migrations**: migrate-mongo provides Laravel-like migrations

## Architecture Comparison

### Laravel Architecture
```
Client → Nginx → PHP-FPM → Laravel → MySQL
                                   → Redis
```

### Node.js Architecture
```
Client → Node.js/Express → MongoDB
                        → Redis
```

## Migration Steps

### Step 1: Understand the Current Structure

Review the Laravel application:
- Controllers in `app/Http/Controllers/Tms/`
- Models in `app/Tms/`
- Routes in `routes/web.php`
- Migrations in `database/migrations/`

### Step 2: Set Up Node.js Backend

```bash
cd tms
cd backend

# Install dependencies
npm install

# Copy environment file
cp .env.example .env

# Update MongoDB connection in .env
```

### Step 3: Start Services

```bash
# From tms/ directory
docker-compose -f docker-compose.backend.yml up -d
```

This starts:
- MongoDB on port 27017
- Redis on port 6379 (mapped to 6380)
- Mailpit on ports 8025 (UI) and 1025 (SMTP)
- Backend API on port 3000

### Step 4: Migrate Data (Optional)

If you have existing data in MySQL:

```bash
# Set MySQL connection details
export MYSQL_HOST=localhost
export MYSQL_PORT=3306
export MYSQL_USER=tms
export MYSQL_PASSWORD=secret
export MYSQL_DATABASE=tms

# Run migration script
cd backend
npm install mysql2
npm run migrate-from-mysql
```

### Step 5: Seed Database

```bash
cd backend
npm run seed
```

Default credentials:
- Email: `admin@tms.dev`
- Password: `password`

### Step 6: Test the API

```bash
# Health check
curl http://localhost:3000/health

# Login
curl -X POST http://localhost:3000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@tms.dev","password":"password"}'

# Get goals (with token)
curl http://localhost:3000/api/goals \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Feature Mapping

### Authentication

**Laravel (Blade + Session):**
```php
Auth::routes();
Route::middleware(['auth'])->group(function() {
    // Protected routes
});
```

**Node.js (JWT API):**
```typescript
POST /api/auth/register
POST /api/auth/login
GET  /api/auth/me (with Authorization header)
```

### Models

**Laravel Model:**
```php
namespace Tms;
class Goal extends Model {
    protected $fillable = ['goal', 'priority', ...];
}
```

**Mongoose Model:**
```typescript
const goalSchema = new Schema({
  goal: { type: String, required: true },
  priority: { type: String, enum: ['A','B','C','D'] },
  userId: { type: Schema.Types.ObjectId, ref: 'User' }
});
export const Goal = mongoose.model('Goal', goalSchema);
```

### Controllers

**Laravel Controller:**
```php
class GoalController extends Controller {
    public function index(Request $request) {
        $goals = Goal::where('user_id', Auth::id())->get();
        return view('goals.index', compact('goals'));
    }
}
```

**Express Controller:**
```typescript
export const getGoals = async (req: AuthRequest, res: Response) => {
  const goals = await Goal.find({ userId: req.user._id });
  res.json({ status: 'success', data: { goals } });
};
```

### Routes

**Laravel Routes:**
```php
Route::get('/goals', 'Tms\\GoalController@index');
Route::post('/goals/edit', 'Tms\\GoalController@edit');
```

**Express Routes:**
```typescript
router.get('/goals', authenticate, goalController.getGoals);
router.put('/goals/:id', authenticate, goalController.updateGoal);
```

### Validation

**Laravel:**
```php
$request->validate([
    'email' => 'required|email',
    'password' => 'required|min:6'
]);
```

**Node.js with Joi:**
```typescript
const schema = Joi.object({
  email: Joi.string().email().required(),
  password: Joi.string().min(6).required()
});
```

### Database Queries

**Laravel (Eloquent):**
```php
$goals = Goal::where('user_id', $userId)
    ->where('status', 'In Progress')
    ->orderBy('deadline')
    ->get();
```

**Node.js (Mongoose):**
```typescript
const goals = await Goal.find({
  userId: userId,
  status: 'In Progress'
}).sort({ deadline: 1 });
```

## Key Differences

### 1. **Request/Response Handling**

**Laravel (Returns Views):**
```php
return view('goals.index', ['goals' => $goals]);
```

**Node.js (Returns JSON for SPA):**
```typescript
res.json({ status: 'success', data: { goals } });
```

### 2. **Database IDs**

- **MySQL**: Auto-increment integers (1, 2, 3...)
- **MongoDB**: ObjectId strings ("507f1f77bcf86cd799439011")

Update frontend to handle ObjectId strings.

### 3. **Relationships**

**Laravel:**
```php
$goal->tasks; // Automatic relationship
```

**Mongoose:**
```typescript
await Goal.findById(id).populate('tasks');
// or
const tasks = await Task.find({ goalId: goal._id });
```

### 4. **Authentication**

**Laravel (Session-based):**
```php
Auth::check()
Auth::id()
Auth::user()
```

**Node.js (JWT Token-based):**
```typescript
// Client sends: Authorization: Bearer <token>
// Middleware decodes JWT and adds user to req.user
const userId = req.user._id;
```

### 5. **Migrations**

**Laravel:**
```bash
php artisan migrate
php artisan migrate:rollback
```

**Node.js:**
```bash
npm run migrate:up
npm run migrate:down
```

## Frontend Changes Required

### 1. **API Base URL**

Update frontend to use new API:

```javascript
// Old Laravel backend
const API_URL = 'http://localhost:8080';

// New Node.js backend
const API_URL = 'http://localhost:3000/api';
```

### 2. **Authentication**

**Old (Session/Cookie):**
```javascript
// Laravel automatically handles CSRF and sessions
fetch('/goals')
```

**New (JWT Token):**
```javascript
const token = localStorage.getItem('token');
fetch('http://localhost:3000/api/goals', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  }
});
```

### 3. **Response Structure**

**Laravel Response:**
```json
{
  "goals": [...]
}
```

**Node.js Response:**
```json
{
  "status": "success",
  "data": {
    "goals": [...]
  }
}
```

### 4. **Error Handling**

**Laravel:**
```json
{
  "errors": {
    "email": ["The email field is required."]
  }
}
```

**Node.js:**
```json
{
  "status": "error",
  "message": "Validation failed"
}
```

## Database Schema Changes

### MySQL to MongoDB Mapping

| MySQL Type | MongoDB Type |
|------------|--------------|
| INT AUTO_INCREMENT | ObjectId |
| VARCHAR(255) | String |
| TEXT | String |
| TINYINT(1) | Boolean |
| DECIMAL(8,2) | Number |
| TIMESTAMP | Date |
| DATE | Date |

### Example Schema Migration

**MySQL:**
```sql
CREATE TABLE goals (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  goal VARCHAR(255) NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

**MongoDB:**
```typescript
{
  _id: ObjectId,
  userId: ObjectId,
  goal: String,
  createdAt: Date,
  updatedAt: Date
}
```

## Performance Considerations

### Indexing

**Laravel (MySQL):**
```php
$table->index('user_id');
$table->index(['user_id', 'status']);
```

**Mongoose (MongoDB):**
```typescript
goalSchema.index({ userId: 1 });
goalSchema.index({ userId: 1, status: 1 });
```

### N+1 Query Problem

**Laravel:**
```php
$goals = Goal::with('tasks')->get(); // Eager loading
```

**Mongoose:**
```typescript
const goals = await Goal.find().populate('tasks');
// Or fetch separately if needed
```

## Testing

### API Testing with curl

```bash
# Register
curl -X POST http://localhost:3000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password123"}'

# Login
curl -X POST http://localhost:3000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# Create Goal (use token from login response)
curl -X POST http://localhost:3000/api/goals \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"goal":"Test Goal","priority":"A","urgency":1,"deadline":"2025-12-31","type":"Personal"}'
```

## Deployment

### Development

```bash
docker-compose -f docker-compose.backend.yml up -d
```

### Production

1. Build the application:
```bash
cd backend
npm run build
```

2. Set environment variables:
```env
NODE_ENV=production
MONGODB_URI=mongodb://user:pass@production-host/tms
JWT_SECRET=strong-random-secret-key
```

3. Run production server:
```bash
npm start
```

## Rollback Plan

If issues arise, you can run both backends simultaneously:

1. Keep Laravel running on port 8080
2. Run Node.js backend on port 3000
3. Test Node.js thoroughly
4. Gradually migrate frontend to use new API
5. Once stable, deprecate Laravel backend

## Common Issues & Solutions

### Issue: MongoDB connection failed

**Solution:**
```bash
# Check if MongoDB is running
docker-compose -f docker-compose.backend.yml ps

# View logs
docker-compose -f docker-compose.backend.yml logs mongodb
```

### Issue: JWT token expired

**Solution:**
Implement refresh token endpoint:
```typescript
POST /api/auth/refresh-token
```

### Issue: CORS errors

**Solution:**
Update CORS configuration in `src/server.ts`:
```typescript
app.use(cors({
  origin: ['http://localhost:5173', 'http://localhost:8080'],
  credentials: true
}));
```

## Next Steps

1. ✅ Complete backend migration
2. ⬜ Update frontend to use new API
3. ⬜ Implement real-time features (Socket.io)
4. ⬜ Add API rate limiting
5. ⬜ Set up monitoring (PM2, Prometheus)
6. ⬜ Deploy to production

## Resources

- [Express.js Documentation](https://expressjs.com/)
- [Mongoose Documentation](https://mongoosejs.com/)
- [MongoDB Manual](https://docs.mongodb.com/)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [JWT.io](https://jwt.io/)

---

**Questions or issues?** Check the troubleshooting section or open an issue on GitHub.
