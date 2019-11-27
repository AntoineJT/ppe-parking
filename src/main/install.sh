
# Install vendors
composer install

# Create .env
cp .env.example .env

# Generate app key
php artisan key:generate

# Indicates what things remains to do
echo 'Installation is partially done! You need to change default db (in .env) by parking and to run sql scripts'
sleep
