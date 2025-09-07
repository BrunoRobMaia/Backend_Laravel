#!/bin/sh

set -e

# Set application environment
if [ "$APP_ENV" = "local" ]; then
    php artisan config:clear
    php artisan view:clear
    php artisan route:clear
    php artisan cache:clear
    php artisan optimize:clear
else
    php artisan config:cache
    php artisan view:cache
    php artisan route:cache
    php artisan optimize
fi

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:monitor > /dev/null 2>&1; do
    sleep 1
done

echo "Database is ready!"

# Run database migrations
php artisan migrate --force

# Clear and cache routes and config
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set directory permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Start the application with supervisor
/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
