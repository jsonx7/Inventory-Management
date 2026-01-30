$env:COMPOSER_HOME = $PWD
$env:COMPOSER_ALLOW_SUPERUSER = '1'
php composer.phar install --no-interaction --prefer-dist --ignore-platform-reqs
