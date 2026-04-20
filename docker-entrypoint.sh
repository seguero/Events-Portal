#!/bin/sh
set -e

cd /var/www/html

if [ -f "composer.json" ] && [ ! -d "vendor" ]; then
    composer install --no-interaction
fi

# Start cron in the background
cron

# Run the main container process (Apache)
exec "$@"