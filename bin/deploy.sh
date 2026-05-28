#!/usr/bin/env bash

# Exit immediately if any command fails, or if an unset variable is referenced
set -euo pipefail

_restoreApp() {
    echo "🚨 Action caught an unexpected exit code. Re-enabling application framework..."
    php artisan up || true
}

trap _restoreApp EXIT

cd ../

DB_FILE="database/database.sqlite"

if [ ! -f "$DB_FILE" ] && grep -q "DB_CONNECTION=sqlite" .env; then
    echo "SQLite database driver detected and missing. Creating database file..."
    touch "$DB_FILE"
fi

echo "Starting deployment..."

git fetch origin

git reset --hard origin/main

php -d allow_url_fopen=1 -d disable_functions=none -d detect_unicode=0 "$(which composer)" install --no-interaction --prefer-dist --optimize-autoloader --no-dev

php artisan down --retry=60

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

npm install
npm run build

php artisan up

echo "Application deployed!"
exit 0
