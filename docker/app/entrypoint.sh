#!/bin/bash

echo "SETTING ENV"
echo "==================="
cp .env.local .env
php artisan key:generate

echo "RUNNING MIGRATION"
echo "==================="
php artisan migrate

#echo "GENERATING SWAGGER DOCUMENTATION"
#echo "==================="
#php artisan l5-swagger:generate

/usr/bin/supervisord -n -c /etc/supervisord.conf