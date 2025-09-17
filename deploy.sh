#!/bin/bash

set -e  # Exit on any error

echo "Starting deployment..."

# Check if user can access Docker
if ! docker --version >/dev/null 2>&1; then
    echo "Error: Docker is not installed or not accessible"
    echo "Please install Docker and ensure you have proper permissions"
    exit 1
fi

# Test Docker access
if ! docker ps >/dev/null 2>&1; then
    echo "Error: Cannot access Docker daemon"
    echo "Please ensure:"
    echo "1. Docker daemon is running: sudo systemctl start docker"
    echo "2. Your user is in docker group: sudo usermod -aG docker \$USER"
    echo "3. Restart your session after adding to docker group"
    exit 1
fi

# Check if .env.production exists
if [ ! -f ".env.production" ]; then
    echo "Error: .env.production file not found"
    echo "Please create .env.production file first"
    exit 1
fi

# Copy production environment file
cp .env.production .env

# Create external network if it doesn't exist
echo "Creating Docker network..."
docker network create nginx-proxy 2>/dev/null || echo "Network nginx-proxy already exists"

# Stop existing containers
echo "Stopping existing containers..."
docker-compose down

# Build and start containers
echo "Building containers..."
docker-compose build --no-cache

echo "Starting containers..."
docker-compose up -d

# Wait for database to be ready
echo "Waiting for database to be ready..."
sleep 45

# Check if containers are running
echo "Checking container status..."
if ! docker-compose ps | grep -q "Up"; then
    echo "Error: Containers failed to start"
    docker-compose logs
    exit 1
fi

# Run Laravel setup commands
echo "Running Laravel setup..."

# Generate app key first
docker-compose exec -u root -T app php artisan key:generate --force

# Wait a bit more for DB to be fully ready
sleep 15

# Fix permissions for storage and bootstrap/cache directories in container
echo "Setting up directory permissions..."
docker-compose exec -u root -T app mkdir -p /var/www/storage/logs
docker-compose exec -u root -T app mkdir -p /var/www/storage/framework/cache/data
docker-compose exec -u root -T app mkdir -p /var/www/storage/framework/sessions
docker-compose exec -u root -T app mkdir -p /var/www/storage/framework/views
docker-compose exec -u root -T app mkdir -p /var/www/bootstrap/cache
docker-compose exec -u root -T app chown -R www:www /var/www/storage /var/www/bootstrap/cache
docker-compose exec -u root -T app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Install all composer dependencies first
echo "Installing all composer dependencies..."
docker-compose exec -u root -T app composer install --no-dev --optimize-autoloader --no-interaction

# Temporarily install Faker for seeding (only in production)
echo "Installing Faker for database seeding..."
docker-compose exec -u root -T app composer require fakerphp/faker --dev --no-interaction

# Run migrations
docker-compose exec -T app php artisan migrate --force

# Seed database
docker-compose exec -T app php artisan db:seed --force

# Remove Faker after seeding to keep production clean
echo "Removing Faker from production dependencies..."
docker-compose exec -u root -T app composer remove fakerphp/faker --dev --no-interaction

# Cache configurations
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

# Create storage link
docker-compose exec -T app php artisan storage:link

echo "Deployment completed successfully!"
echo "Your application should be accessible at port 8080"
echo "Configure your Nginx Proxy Manager to point to: bimbingan-nginx:80"
echo ""
echo "Container status:"
docker-compose ps
