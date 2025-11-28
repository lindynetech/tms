#!/bin/bash

echo "=========================================="
echo "   TMS - Time Management System Setup"
echo "=========================================="
echo ""

# Check if .env exists
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env 2>/dev/null || echo "⚠️  No .env.example found, please create .env manually"
fi

# Start Docker containers
echo "🐳 Starting Docker containers..."
docker compose up -d

echo ""
echo "⏳ Waiting for services to be ready (30 seconds)..."
sleep 30

# Check if database needs initialization
echo ""
echo "🔍 Checking database status..."
USER_COUNT=$(docker compose exec -T mysql mysql -u${DB_USERNAME:-tms} -p${DB_PASSWORD:-secret} ${DB_DATABASE:-tms} -sN -e "SELECT COUNT(*) FROM users;" 2>/dev/null || echo "0")

if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "🌱 Database is empty, importing seed data..."
    docker compose exec -T mysql mysql -u${DB_USERNAME:-tms} -p${DB_PASSWORD:-secret} ${DB_DATABASE:-tms} < seed.sql
    echo "✅ Database seeded successfully!"
else
    echo "ℹ️  Database already contains $USER_COUNT user(s), skipping seed"
fi

# Run Laravel setup
echo ""
echo "🔧 Running Laravel setup commands..."
docker compose exec app php artisan key:generate --force 2>/dev/null
docker compose exec app php artisan migrate --force
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan storage:link 2>/dev/null || echo "⚠️  Storage link already exists"

echo ""
echo "=========================================="
echo "✅ Setup Complete!"
echo "=========================================="
echo ""
echo "📱 Application URL: http://localhost:8080"
echo "📧 Mailpit URL: http://localhost:8025"
echo ""
echo "Default Login:"
echo "  Email: admin@tms.dev"
echo "  Password: password"
echo ""
echo "Useful Commands:"
echo "  task                      # Show all commands"
echo "  task logs                 # View logs"
echo "  task stop                 # Stop containers"
echo "  task restart              # Restart containers"
echo "  task fresh                # Fresh installation"
echo "  docker compose down -v    # Stop and remove containers + volumes"
echo ""
