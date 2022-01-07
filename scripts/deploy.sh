#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode
(php artisan down) || true

# Pull latest
git pull origin master

/var/www/.perm_fix.sh KUISLAM

# Install composer dependencies
export COMPOSER_ALLOW_SUPERUSER=1
composer dump-autoload
composer install

# Run database migrations
php artisan migrate --force

# Shortcut storage
php artisan storage:link

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Compile npm assets
npm cache clean --force
rm -rf node_modules
npm install
npm run prod

# Exit maintenance mode
php artisan up

# post deployment clearance
git restore public/
git restore package-lock.json

echo "Deployment finished!"