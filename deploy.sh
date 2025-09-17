#!/bin/bash

echo "Starting deployment..."

# Copy production environment file
cp .env.production .env

# Create external network if it doesn't exist
docker network create nginx-proxy || true

# Build and start containers
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Wait for database to be ready
echo "Waiting for database to be ready..."
sleep 30

# Run Laravel setup commands
echo "Running Laravel setup..."
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app php artisan storage:link

# Set proper permissions
docker-compose exec app chown -R www:www /var/www/storage
docker-compose exec app chmod -R 755 /var/www/storage

echo "Deployment completed!"
echo "Your application should be accessible at port 8080"
echo "Configure your Nginx Proxy Manager to point to: bimbingan-nginx:80"
