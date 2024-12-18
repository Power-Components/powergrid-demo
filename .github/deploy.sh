#!/bin/bash
                  #╔═════════════════════╗#
                  #║   PowerGrid Demo    ║#
                  #╚═════════════════════╝#

# ══════════════ STYLES ═════════

NC='\033[0m'
GREEN='\033[0;32m'
LABEL_ERROR="\n\033[048;5;9m ERROR ${NC} "

#Ascii Logo encoded in Base64
LOGO=$(echo -n "ICAgICAgICAgICAgXDAzM1sxOzMzbSBfX1wwMzNbMG0gICAgIFwwMzNbMDszMm1fX19fICAgICAgICAgICAgICAgICAgICAgICAgICBfX19fX18gICAgIF8gICAgIF9fXDAzM1swbQogICAgICAgICAgICBcMDMzWzE7MzNtLyAvXyxcMDMzWzBtICBcMDMzWzA7MzJtLyBfXyBcX19fXyBfICAgICAgX19fX18gIF9fX19fLyBfX19fL19fX18oXylfX18vIC9cMDMzWzBtCiAgICAgICAgICAgIFwwMzNbMTszM20vXyAsJ1wwMzNbMG0gXDAzM1swOzMybS8gL18vIC8gX18gXCB8IC98IC8gLyBfIFwvIF9fXy8gLyBfXy8gX19fLyAvIF9fICAvIFwwMzNbMG0KICAgICAgICAgICAgXDAzM1sxOzMzbS8nXDAzM1swbSAgIFwwMzNbMDszMm0vIF9fX18vIC9fLyAvIHwvIHwvIC8gIF9fLyAvICAvIC9fLyAvIC8gIC8gLyAvXy8gLyAgXDAzM1swbQogICAgICAgICAgICAgICAgXDAzM1swOzMybS9fLyAgICBcX19fXy98X18vfF9fL1xfX18vXy8gICBcX19fXy9fLyAgL18vXF9fLF8vICAgXDAzM1swbSAg" | base64 --decode)


echo -e "${LOGO}\n"

read -p "Continue with the deployment process? [y/N]"

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
   echo "Aborting!" 
   exit
fi

cd /home/ploi/demo.livewire-powergrid.com

# Turn on maintenance mode
php artisan down || true

git stash
git checkout main
git pull origin main: --rebase

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "" | sudo -S service php8.3-fpm reload

# Run database migrations
php artisan migrate:fresh --seed --force

# Clear caches
php artisan cache:clear

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

# Clear and cache views
php artisan view:cache

# Install node modules
npm ci
npm run prod

# Turn off maintenance mode
php artisan up