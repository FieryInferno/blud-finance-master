#!/bin/sh

now=$(date +"%T")
file="public/deploy.txt"
git=$(which git)
php=$(which php)
composer=$(which composer)

# Remove file content
echo -n > $file;

echo "======= $now ======= " >> $file

echo "> Maintenance: DOWN" >> $file
# activate maintenance mode
$php artisan down >> $file

echo "> Update source code" >> $file
# update source code
$git pull >> $file

echo "> Composer Update" >> $file
# update PHP dependencies
# --no-interaction Do not ask any interactive question
# --no-dev  Disables installation of require-dev packages.
# --prefer-dist  Forces installation from package dist even for dev versions.

#composer install --no-interaction --no-dev --prefer-dist
$composer update --no-interaction --no-dev --prefer-dist >> $file

echo "> Migrate Database" >> $file
# update database
$php artisan migrate >> $file
# --force  Required to run when in production.

echo "> Optimize" >> $file
# optimize 
$php artisan optimize >> $file

#echo "> Send to Slack #deploy" >> $file
#curl -X POST -H 'Content-type: application/json' --data '{"text":"[E-BLUD Kesehatan] Automated script deployed!"}' https://hooks.slack.com/services/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 >> $file

echo "> Maintenance: UP" >> $file
# stop maintenance mode
$php artisan up >> $file

echo "======= $now ======= " >> $file
