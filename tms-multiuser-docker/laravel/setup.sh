#! /bin/sh

sleep 60 && \
php artisan migrate && \
php artisan db:seed
