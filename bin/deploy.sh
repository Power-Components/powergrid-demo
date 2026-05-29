#!/usr/bin/env bash

# Exit immediately if any command fails, or if an unset variable is referenced
set -euo pipefail

_restoreApp() {
    echo "Action caught an unexpected exit code. Re-enabling application framework..."
    php artisan up || true
}

trap _restoreApp ERR

if [[ ! -f "composer.json" ]] || [[ ! -f ".env" ]]; then
    echo "Error: This script must be run from the project root directory!"
    exit 1
fi

DB_FILE="database/database.sqlite"

if [ ! -f "$DB_FILE" ] && grep -q "DB_CONNECTION=sqlite" .env; then
    echo "SQLite database driver detected and missing. Creating database file..."
    touch "$DB_FILE"
fi

echo "Starting deployment..."
 
COMPOSER_PATH=$(command -v composer)
php -d allow_url_fopen=1 -d disable_functions=none -d detect_unicode=0 "$COMPOSER_PATH" install --no-interaction --prefer-dist --optimize-autoloader --no-dev

php artisan down --retry=60

php artisan migrate --force

php artisan optimize

php artisan view:cache

php artisan queue:restart

if [ -f "package.json" ]; then
    npm ci
    npm run build
fi

php artisan up

echo "Application deployed!"

trap - ERR
exit 0
