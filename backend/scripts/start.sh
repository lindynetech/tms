#!/bin/bash

set -e

echo "🚀 Starting TMS Backend..."
echo ""

# Go to backend directory
cd "$(dirname "$0")/.."

if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    echo "✓ .env file created"
    echo ""
fi

if [ ! -d "node_modules" ]; then
    echo "📦 Installing dependencies..."
    npm install
    echo "✓ Dependencies installed"
    echo ""
fi

# Go to project root
cd ..

echo "🐳 Starting Docker services..."
docker compose -f docker-compose.backend.yml up -d

echo ""
echo "⏳ Waiting for MongoDB to be ready..."
sleep 5

echo ""
echo "🌱 Seeding database..."
docker compose -f docker-compose.backend.yml exec -T backend npm run seed

echo ""
echo "✅ TMS Backend is ready!"
echo ""
echo "📍 API URL: http://localhost:3000"
echo "📍 MongoDB: localhost:27017"
echo "📍 Mailpit: http://localhost:8025"
echo ""
echo "🔐 Default Login:"
echo "   Email: admin@tms.dev"
echo "   Password: password"
echo ""
echo "📚 Documentation: backend/README.md"
echo ""
echo "🧪 Test the API:"
echo "   curl http://localhost:3000/health"
echo ""
