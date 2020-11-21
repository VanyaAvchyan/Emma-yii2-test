#Autoloader Optimization
composer install --optimize-autoloader --no-dev
composer update

php yii migrate --interactive=0