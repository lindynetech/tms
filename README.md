# TMS - Time Management System

A comprehensive multi-user SaaS application for personal productivity and time management. Built on Laravel 12 with a modern Docker architecture.

## Overview

TMS (Time Management System) is a feature-rich productivity platform that helps users manage their goals, tasks, habits, reading lists, and brainstorming sessions. Originally built on Laravel 5.8, it has been migrated to Laravel 12 with PHP 8.4 and runs on a vanilla Docker stack.

### Key Features

- **Goal Management**: Create and track long-term goals with tasks and subtasks
- **Daily Goals**: Plan and monitor daily objectives
- **Habit Tracking**: Build and maintain positive habits with daily check-ins
- **Mindstorms**: Brainstorming tool for capturing and organizing ideas
- **Reading List**: Track books and reading progress
- **Vendor Management**: Organize assignees and collaborators
- **Billing Integration**: Built-in subscription and payment tracking
- **Multi-User Support**: SaaS-ready with user authentication and authorization

### Tech Stack

- **Framework**: Laravel 12.40.1
- **PHP**: 8.4 (PHP-FPM)
- **Database**: MySQL 8.0
- **Cache/Queue**: Redis (Alpine)
- **Web Server**: Nginx (Alpine)
- **Frontend**: Vite + Node.js 20
- **Containerization**: Docker Compose (Vanilla setup, no Sail)

## Quick Start

### Prerequisites

- Docker Engine 20.10+
- Docker Compose V2+
- Git

### Installation

**Option 1: Automated Setup (Recommended)**

```bash
# Clone and setup in one command
git clone <repository-url> tms && cd tms
./bootstrap.sh
```

**Option 2: Using Task**

```bash
git clone <repository-url> tms && cd tms
task install
```

**Option 3: Manual Setup**

```bash
# Clone the repository
git clone <repository-url> tms && cd tms

# Create environment file
cp .env.example .env

# Start containers
task start
# OR
```bash
# Using helper script
task up

# Or using docker compose directly
docker compose up -d
```

3. **Verify containers are running**

```bash
task ps
# Or: docker compose ps
```

### Automatic Database Seeding

The application automatically seeds the database on first startup with sample data including:
- 1 Admin user
- 2 Sample goals with tasks
- 2 Daily goals
- 3 Reading list items with notes
- Sample vendors and billing data

**Default Login:**
- **Email**: admin@tms.dev
- **Password**: password

**Access Points:**
- **Web Application**: http://localhost:8080
- **Mailpit (Email Testing)**: http://localhost:8025

### Reseed Database

To reset and reseed the database:

```bash
task clean      # Remove all data
task install    # Fresh setup with seed data
```

## Docker Services

| Service | Container | Port | Purpose |
|---------|-----------|------|---------|
| **Nginx** | tms-nginx | 8080 | Web server & reverse proxy |
| **PHP-FPM** | tms-app | 9000 | Application backend |
| **MySQL** | tms-mysql | 3306 | Database |
| **Redis** | tms-redis | 6380→6379 | Cache, sessions & queues |
| **Mailpit** | tms-mailpit | 8025, 1025 | Email testing UI & SMTP |
| **Node** | tms-node | 5173 | Vite dev server (optional) |

## Usage

### Quick Commands (Taskfile)

The Taskfile provides convenient commands (requires [Task](https://taskfile.dev)):

```bash
task               # Show all available commands
task start         # Start containers
task stop          # Stop containers
task restart       # Restart containers
task logs          # View container logs
task shell         # Open bash in app container
task mysql         # Open MySQL shell
task cache-clear   # Clear Laravel caches
task seed          # Import seed data
task clean         # Remove all containers and data
task fresh         # Complete fresh installation
task migrate       # Run database migrations
task artisan       # Run artisan command (task artisan -- migrate)
task composer      # Run composer command (task composer -- install)
task tinker        # Open Laravel Tinker
task test          # Run tests
```

**Install Task:** If you don't have Task installed:
```bash
# Quick install (includes in project directory)
./.taskfile-setup.sh

# Manual install - macOS
brew install go-task

# Manual install - Linux
sh -c "$(curl --location https://taskfile.dev/install.sh)" -- -d -b ~/.local/bin
export PATH="$HOME/.local/bin:$PATH"  # Add to ~/.bashrc or ~/.zshrc

# Or download binary from https://github.com/go-task/task/releases
```

### Using Helper Script

These commands are available through Task:

```bash
# Container management
task up              # Start containers
task down            # Stop containers
task restart         # Restart all containers
task ps              # Show container status
task logs            # View logs
task logs nginx      # View specific service logs

# Application commands
task artisan migrate
task artisan make:model Article -mcr
task artisan tinker
task fresh           # Fresh migrate + seed

# Composer
task composer install
task composer require package/name

# Testing
task test

# Shell access
task shell           # App container
task mysql           # MySQL CLI
task redis           # Redis CLI
```

### Using Docker Compose Directly

```bash
# Start/stop
docker compose up -d
docker compose down

# Run artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan tinker

# Access shell
docker compose exec app bash

# View logs
docker compose logs -f app
docker compose logs -f nginx
```

## Development

### Environment Configuration

Database and Redis are configured via environment variables in `.env`:

```env
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=tms
DB_USERNAME=tms
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PORT=6379
```

### Frontend Assets

```bash
# Start Vite dev server (hot reload)
docker compose --profile dev up -d node

# Build for production
docker compose exec node npm run build
```

### Database Operations

```bash
# Run migrations
task artisan migrate

# Fresh start (drops all tables)
task artisan migrate:fresh

# Seed database
task artisan db:seed

# Backup database
docker compose exec mysql mysqldump -u tms -psecret tms > backup.sql

# Restore database
docker compose exec -T mysql mysql -u tms -psecret tms < backup.sql
```

## Project Structure

```
tms/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   └── Tms/                 # Custom TMS namespace
│       ├── GoalController.php
│       ├── TaskController.php
│       ├── HabitController.php
│       └── ...
├── docker/
│   ├── nginx/
│   │   └── default.conf     # Nginx configuration
│   └── php/
│       └── local.ini        # PHP settings
├── docs/
│   ├── VANILLA_DOCKER_GUIDE.md      # Detailed Docker guide
│   ├── VANILLA_SETUP_COMPLETE.md    # Setup summary
│   ├── MIGRATION_SUMMARY.md         # Laravel 5.8→12 migration
│   └── DATABASE_IMPORT_SUMMARY.md   # Database info
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeds/              # Database seeders
│   └── factories/          # Model factories
├── resources/
│   └── views/              # Blade templates
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
├── docker-compose.yml      # Docker services definition
├── Dockerfile              # PHP-FPM image
├── Taskfile.yml            # Task runner configuration
└── README.md               # This file
```

## Database Schema

### Core Tables

- **users** - User accounts
- **billing** - Subscription and payment info
- **goals** - User goals
- **goals_tasks** - Tasks for goals
- **goals_sub_tasks** - Subtasks
- **daily_goals** - Daily objectives
- **habits** - Habit definitions
- **habits_days** - Daily habit tracking
- **mindstorms** - Brainstorming questions
- **mindstorms_ideas** - Captured ideas
- **readinglist** - Reading list items
- **vendors** - Vendor/assignee management
- **sessions** - User sessions

## Troubleshooting

### Port Conflicts

If port 8080 is already in use, edit `docker-compose.yml`:

```yaml
nginx:
  ports:
    - "8081:80"  # Change from 8080
```

### Permission Issues

```bash
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache
```

### Clear Caches

```bash
task cache-clear           # Clears all caches
```

### Complete Reset

```bash
docker compose down -v
docker compose build --no-cache
docker compose up -d
task artisan migrate
```

### View Application Logs

```bash
task artisan tail
# Or directly:
docker compose exec app tail -f storage/logs/laravel.log
```

## Architecture

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │ :8080
       ▼
┌─────────────┐
│    Nginx    │ ← Static files
└──────┬──────┘
       │ FastCGI :9000
       ▼
┌─────────────┐
│  PHP-FPM    │ ← TMS Application
│  (Laravel)  │
└──┬───────┬──┘
   │       │
   ▼       ▼
┌──────┐ ┌──────┐
│MySQL │ │Redis │
└──────┘ └──────┘
```

## Documentation

- **[Docker Setup Guide](docs/VANILLA_DOCKER_GUIDE.md)** - Complete Docker documentation
- **[Setup Summary](docs/VANILLA_SETUP_COMPLETE.md)** - Quick reference and commands
- **[Migration Summary](docs/MIGRATION_SUMMARY.md)** - Laravel 5.8 to 12 migration details
- **[Database Import](docs/DATABASE_IMPORT_SUMMARY.md)** - Database structure and import info

## Contributing

1. Create a feature branch from `main`
2. Make your changes
3. Run tests: `task test`
4. Submit a pull request

## Support

For issues and questions:
- Check the [troubleshooting section](#troubleshooting)
- Review documentation in the `docs/` folder
- Check Laravel logs: `task logs`

## License

Proprietary - All rights reserved

---

**Built with Laravel 12 • Docker • PHP 8.4 • MySQL 8.0 • Redis**
