# TMS - Time Management System Docker Setup Complete! ✅

## Summary

Your TMS application (Laravel 12-based) is now running with **vanilla Docker containers** (no Sail dependency).

## Current Status

✅ **All containers running:**
- **Nginx** (tms-nginx) - http://localhost:8080
- **PHP-FPM 8.4** (tms-app) - Backend application
- **MySQL 8.0** (tms-mysql) - Port 3306
- **Redis** (tms-redis) - Port 6380 (host) → 6379 (container)

✅ **Initial setup completed:**
- Application built successfully
- Database migrations run
- Application responding with HTTP 200 OK

## Quick Access

| Service | Access |
|---------|--------|
| **Web Application** | http://localhost:8080 |
| **MySQL** | `localhost:3306` (laravel/secret) |
| **Redis** | `localhost:6380` |
| **Container Shell** | `./docker.sh shell` |

## Project Structure

```
/home/deploy/Work/CICD/ops-apps/tms/
├── docker/
│   ├── nginx/
│   │   └── default.conf       # Nginx web server config
│   └── php/
│       └── local.ini           # PHP configuration
├── docs/
│   ├── VANILLA_DOCKER_GUIDE.md    # Complete Docker guide
│   ├── VANILLA_SETUP_COMPLETE.md  # This file
│   ├── MIGRATION_SUMMARY.md       # Laravel 5.8 → 12 migration
│   └── DATABASE_IMPORT_SUMMARY.md # Database import info
├── Dockerfile                   # PHP-FPM container
├── docker-compose.yml           # Services orchestration
├── .dockerignore               # Build exclusions
├── docker.sh                   # Helper script (executable)
└── [TMS app files...]
```

## Essential Commands

### Using Helper Script (Recommended)

```bash
cd /home/deploy/Work/CICD/ops-apps/tms

# Container management
./docker.sh up              # Start containers
./docker.sh down            # Stop containers
./docker.sh ps              # Show status
./docker.sh logs            # View logs
./docker.sh restart         # Restart containers

# Laravel/Artisan commands
./docker.sh artisan migrate
./docker.sh artisan make:model Post -mcr
./docker.sh artisan tinker

# Composer
./docker.sh composer require package/name
./docker.sh composer update

# Testing
./docker.sh test

# Access shells
./docker.sh shell           # App container
./docker.sh mysql           # MySQL CLI
./docker.sh redis           # Redis CLI
```

### Using Docker Compose Directly

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# Run artisan commands
docker compose exec app php artisan migrate

# Run composer commands
docker compose exec app composer install

# Access shell
docker compose exec app bash

# View logs
docker compose logs -f
```

## Architecture

```
┌─────────────────┐
│  Browser/Client │
└────────┬────────┘
         │ http://localhost:8080
         ▼
┌─────────────────┐
│  Nginx (alpine) │  ← Static files
│   Port 80→8080  │
└────────┬────────┘
         │ FastCGI (port 9000)
         ▼
┌─────────────────┐
│ PHP-FPM 8.4     │
│ (Custom Image)  │  ← TMS application
└───┬─────────┬───┘
    │         │
    ▼         ▼
┌──────┐  ┌──────┐
│MySQL │  │Redis │
│ 8.0  │  │Alpine│
└──────┘  └──────┘
```

## What's Different from Sail

### Vanilla Docker Setup:
✅ Standard Docker commands
✅ Custom Dockerfile with full control
✅ Separate Nginx container (more production-like)
✅ Smaller, focused images
✅ No vendor dependencies (no Laravel Sail package)
✅ Better for production deployment
✅ Learn actual Docker architecture

### Configuration Files You Control:

1. **Dockerfile** - PHP-FPM container with extensions
2. **docker-compose.yml** - Service orchestration
3. **docker/nginx/default.conf** - Nginx configuration
4. **docker/php/local.ini** - PHP settings

## Container Details

### PHP-FPM Container (tms-app)
- **Base Image**: php:8.4-fpm
- **Extensions**: PDO MySQL, Redis, GD, Zip, Intl, Bcmath, Opcache
- **Includes**: Composer
- **Working Dir**: /var/www/html
- **User**: www-data

### Nginx Container (tms-nginx)
- **Base Image**: nginx:alpine
- **Exposed Port**: 8080 → 80
- **Document Root**: /var/www/html/public
- **Features**: Gzip, Security headers, FastCGI to PHP-FPM

### MySQL Container (tms-mysql)
- **Image**: mysql:8.0
- **Port**: 3306
- **Database**: tms
- **User**: tms / secret
- **Persistent**: Volume `mysql_data`

### Redis Container (tms-redis)
- **Image**: redis:alpine
- **Port**: 6380 (host) → 6379 (container)
- **Persistent**: Volume `redis_data`

## Environment Variables

Current `.env` configuration:

```env
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql           # Container name (Docker network)
DB_PORT=3306
DB_DATABASE=tms
DB_USERNAME=tms
DB_PASSWORD=secret

REDIS_HOST=redis        # Container name (Docker network)
REDIS_PORT=6379         # Internal container port
```

## Next Steps

### 1. Start Development

```bash
# Create your first controller
./docker.sh artisan make:controller HomeController

# Create a model with migration
./docker.sh artisan make:model Article -mcr

# Edit routes
# File: routes/web.php
```

### 2. Frontend Development

```bash
# Install npm packages (if needed)
docker compose exec node npm install

# Start Vite dev server (optional, uses profile)
docker compose --profile dev up -d node

# Or build for production
docker compose exec node npm run build
```

### 3. Database Operations

```bash
# Run migrations
./docker.sh artisan migrate

# Create a seeder
./docker.sh artisan make:seeder UserSeeder

# Seed the database
./docker.sh artisan db:seed

# Fresh start (drops all tables)
./docker.sh fresh
```

## Common Tasks

### Add a New PHP Extension

Edit `Dockerfile`:

```dockerfile
RUN docker-php-ext-install pdo_pgsql
```

Then rebuild:

```bash
./docker.sh rebuild
```

### Change PHP Settings

Edit `docker/php/local.ini`:

```ini
memory_limit = 1024M
upload_max_filesize = 100M
```

Then restart:

```bash
./docker.sh restart
```

### Change Nginx Configuration

Edit `docker/nginx/default.conf` and restart:

```bash
./docker.sh restart nginx
```

### View Logs

```bash
# All logs
./docker.sh logs

# Specific service
docker compose logs -f nginx
docker compose logs -f app
```

## Troubleshooting

### Port Already in Use

Edit `docker-compose.yml` to change ports:

```yaml
nginx:
  ports:
    - "8081:80"  # Change from 8080
```

### Permission Errors

```bash
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache
```

### Clear All Caches

```bash
./docker.sh artisan config:clear
./docker.sh artisan cache:clear
./docker.sh artisan view:clear
./docker.sh artisan route:clear
```

### Complete Reset

```bash
# Stop and remove everything
docker compose down -v

# Rebuild from scratch
docker compose build --no-cache
docker compose up -d

# Run migrations
./docker.sh artisan migrate
```

## File Locations

```
├── Dockerfile                    # PHP-FPM build instructions
├── docker-compose.yml            # Service definitions
├── docker.sh                     # Helper script
├── .dockerignore                # Build exclusions
├── docker/
│   ├── nginx/default.conf       # Nginx config
│   └── php/local.ini            # PHP config
└── VANILLA_DOCKER_GUIDE.md      # Full documentation
```

## Resources

- **Documentation**: See `docs/VANILLA_DOCKER_GUIDE.md` for complete guide
- **Laravel Docs**: https://laravel.com/docs/12.x
- **Docker Docs**: https://docs.docker.com/
- **PHP-FPM**: https://www.php.net/manual/en/install.fpm.php
- **Nginx**: https://nginx.org/en/docs/

## Quick Reference

```bash
# Daily workflow
./docker.sh up                    # Start day
./docker.sh logs -f              # Watch logs
./docker.sh artisan migrate      # Run migrations
./docker.sh test                  # Run tests
./docker.sh down                  # End day

# Development
./docker.sh artisan tinker       # REPL
./docker.sh composer require pkg # Add package
./docker.sh shell                 # Debug in container

# Database
./docker.sh mysql                 # MySQL CLI
./docker.sh artisan migrate:fresh # Fresh start
./docker.sh artisan db:seed      # Seed data
```

---

## MCP Servers Used
- None (standard Docker tools)

**Your vanilla Docker setup is ready for development!** 🐳🚀

No Sail dependencies • Full control • Production-ready architecture
