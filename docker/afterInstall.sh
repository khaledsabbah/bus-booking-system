# Fix Storage Permessions
cp .env.example .env;
composer install;
chmod 755 -R storage/logs/;
chmod 777 -R storage/framework/sessions/;
chmod o+w ./storage/ -R;
chmod 777 -R storage/framework/views/;
chmod 777 -R storage/framework/cache/;
chmod 777 -R bootstrap/cache/;

# Optmize Application
php artisan optimize:clear;

php artisan migrate;
php artisan db:seed;
#npm run dev