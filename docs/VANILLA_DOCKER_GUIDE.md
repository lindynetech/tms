# TMS - Time Management System Docker Setup Guide

## Architecture

This setup uses separate Docker containers for each service:

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Nginx     │────▶│   PHP-FPM   │────▶│    MySQL    │
│  (Port 80)  │     │   (Port     │     │  (Port      │
│             │     │    9000)    │     │   3306)     │
└─────────────┘     └─────────────┘     └─────────────┘
                           │
                           ▼
                    ┌─────────────┐
                    │    Redis    │
                    │  (Port      │
                    │   6379)     │
                    └─────────────┘
```

## Services

| Service | Container Name | Port | Purpose |
|---------|---------------|------|---------|
| **Nginx** | tms-nginx | 8080 | Web server |
| **PHP-FPM** | tms-app | 9000 | PHP application |
| **MySQL** | tms-mysql | 3306 | Database |
| **Redis** | tms-redis | 6379 | Cache/Queue/Sessions |
| **Node** | tms-node | 5173 | Vite dev server (optional) |

## Quick Start

> **Note:** This guide uses Docker Compose V2 syntax (`docker compose` instead of `docker-compose`)

### 1. Build and Start Containers

```bash
cd /home/deploy/Work/CICD/ops-apps/tms

# Build the containers
docker compose build

# Start all services
docker compose up -d

# Check status
docker compose ps
```

### 2. Install Dependencies and Setup

```bash
# Install PHP dependencies (already done during build)
docker compose exec app composer install

# Generate application key (if needed)
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate

# Create storage link
docker compose exec app php artisan storage:link
```

### 3. Access Your Application

- **Web Application**: http://localhost:8080
- **Direct MySQL**: `localhost:3306`
- **Direct Redis**: `localhost:6379`

## Using the Helper Script

Make the helper script executable:

```bash
chmod +x docker.sh
```

### Available Commands

```bash
# Container Management
./docker.sh up              # Start containers
./docker.sh down            # Stop containers
./docker.sh restart         # Restart containers
./docker.sh build           # Build containers
./docker.sh rebuild         # Rebuild from scratch
./docker.sh ps              # Show container status
./docker.sh logs            # Show all logs
./docker.sh logs nginx      # Show specific service logs

# Laravel Commands
./docker.sh artisan migrate
./docker.sh artisan make:controller UserController
./docker.sh artisan db:seed
./docker.sh artisan tinker
./docker.sh artisan queue:work
./docker.sh fresh           # Fresh migrate + seed

# Composer
./docker.sh composer install
./docker.sh composer require vendor/package
./docker.sh composer update

# Testing
./docker.sh test
./docker.sh test --filter=UserTest

# Shell Access
./docker.sh shell           # App container bash
./docker.sh mysql           # MySQL CLI
./docker.sh redis           # Redis CLI
```

## Manual Docker Commands

### Container Management

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# Rebuild containers
docker compose build --no-cache

# View logs
docker compose logs -f
docker compose logs -f app
docker compose logs -f nginx

# Check status
docker compose ps
```

### Execute Commands in Containers

```bash
# Artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan make:model Post -mcr

# Composer commands
docker compose exec app composer install
docker compose exec app composer require laravel/sanctum

# Access container shell
docker compose exec app bash

# Run tests
docker compose exec app php artisan test
```

### Database Access

```bash
# MySQL CLI
docker compose exec mysql mysql -u tms -psecret tms

# Or use a GUI tool:
# Host: localhost
# Port: 3306
# User: tms
# Password: secret
# Database: tms
```

### Redis Access

```bash
# Redis CLI
docker compose exec redis redis-cli

# Test Redis
docker compose exec redis redis-cli ping

# Note: Redis is exposed on host port 6380 (to avoid conflicts)
```

## Frontend Development (Optional)

### Start Node/Vite Dev Server

```bash
# Start Node service for development
docker compose --profile dev up -d node

# Or manually
docker compose exec node npm install
docker compose exec node npm run dev
```

### Build for Production

```bash
docker compose exec node npm run build
```

## File Structure

```
tms/
├── docker/
│   ├── nginx/
│   │   └── default.conf       # Nginx configuration
│   └── php/
│       └── local.ini           # PHP configuration
├── docs/
│   ├── VANILLA_DOCKER_GUIDE.md    # This file
│   ├── VANILLA_SETUP_COMPLETE.md  # Setup summary
│   ├── MIGRATION_SUMMARY.md       # Migration docs
│   └── DATABASE_IMPORT_SUMMARY.md # DB import info
├── Dockerfile                   # PHP-FPM container definition
├── docker-compose.yml           # Services orchestration
├── .dockerignore               # Files to exclude from build
├── docker.sh                   # Helper script
└── app/                        # TMS application (Laravel-based)
```

## Configuration Files

### Dockerfile (PHP-FPM)
- Base: `php:8.4-fpm`
- Extensions: MySQL, Redis, GD, Zip, Intl, etc.
- Composer included
- Permissions configured

### Nginx Configuration
- Location: `docker/nginx/default.conf`
- Document root: `/var/www/html/public`
- PHP-FPM integration
- Security headers
- Gzip compression

### PHP Configuration
- Location: `docker/php/local.ini`
- Upload limit: 40MB
- Memory limit: 512MB
- OPcache enabled
- Timezone: UTC

## Environment Variables

Edit `.env` file:

```env
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql                  # Container name
DB_PORT=3306
DB_DATABASE=tms
DB_USERNAME=tms
DB_PASSWORD=secret

REDIS_HOST=redis               # Container name
REDIS_PORT=6379
```

## Troubleshooting

### Permission Issues

```bash
# Fix storage permissions
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache
```

### Rebuild Containers

```bash
# Complete rebuild
docker compose down -v
docker compose build --no-cache
docker compose up -d
```

### Clear Laravel Cache

```bash
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear
```

### View Container Logs

```bash
# All logs
docker compose logs -f

# Specific service
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f mysql
```

### Database Connection Issues

```bash
# Check MySQL is healthy
docker compose ps

# Test connection
docker compose exec app php artisan migrate:status

# Check MySQL logs
docker compose logs mysql
```

### Port Already in Use

Edit `docker-compose.yml` and change port mappings:

```yaml
nginx:
  ports:
    - "8080:80"  # Change 8080 to another port
```

## Production Considerations

### 1. Optimize PHP-FPM

Edit `docker/php/local.ini`:

```ini
display_errors = Off
opcache.validate_timestamps = 0
opcache.max_accelerated_files = 20000
```

### 2. Optimize Laravel

```bash
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app composer install --optimize-autoloader --no-dev
```

### 3. Use Environment-specific Compose Files

Create `docker-compose.prod.yml`:

```yaml
version: '3.8'
services:
  app:
    restart: always
  nginx:
    restart: always
```

Run with:

```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## Useful Commands

### Database Management

```bash
# Fresh migration
./docker.sh artisan migrate:fresh

# Seed database
./docker.sh artisan db:seed

# Fresh migration + seed
./docker.sh fresh

# Backup database
docker compose exec mysql mysqldump -u tms -psecret tms > backup.sql

# Restore database
docker compose exec -T mysql mysql -u tms -psecret tms < backup.sql
```

### Queue Workers

```bash
# Start queue worker
docker compose exec app php artisan queue:work

# Or run in background
docker compose exec -d app php artisan queue:work
```

### Scheduler

Add to crontab or create a separate container for the scheduler:

```bash
* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1
```

## Advantages Over Sail

✅ Full control over container configuration
✅ Standard Docker commands
✅ Production-ready setup
✅ Smaller image sizes
✅ Better understanding of architecture
✅ Easier to customize
✅ No vendor lock-in

## Resources

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Reference](https://docs.docker.com/compose/)
- [Laravel Documentation](https://laravel.com/docs/12.x)
- [PHP-FPM Configuration](https://www.php.net/manual/en/install.fpm.configuration.php)
- [Nginx Configuration](https://nginx.org/en/docs/)

---

**Happy Coding!** 🐳🚀
