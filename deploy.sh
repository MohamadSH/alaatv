

#!/bin/bash

cd /home/alaa/alaatv
php artisan down
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S service php7.3-fpm reload
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S rm -rf /cache_ramdisk/fastFCGIcache/*
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S rm -rf /cache_ramdisk/fastFCGIcache/*

composer install
 # perform any migrations                                                                                
php artisan migrate --force                                                                             
php artisan cache:clear                                                                                 
php artisan route:clear
php artisan config:clear
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S php artisan view:clear
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S php artisan view:cache                                
                                                                                                         
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chown alaa:www-data -R /home/alaa/alaatv
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chgrp -R www-data storage bootstrap/cache             
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chmod -R ug+rwx storage bootstrap/cache               
                                                                                                         
php artisan route:cache                                                                                 
php artisan config:cache                                                                                
php artisan optimize
composer dump
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S rm -rf /cache_ramdisk/fastFCGIcache/*
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S rm -rf /cache_ramdisk/fastFCGIcache/*
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S service php7.3-fpm reload
php artisan up
