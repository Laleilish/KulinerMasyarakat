#!/bin/bash
set -e

# Create required storage directories
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cache config and routes for performance
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations if DB is configured
php artisan migrate --force || echo "Migration skipped or failed"

# Start Apache
exec apache2-foreground
