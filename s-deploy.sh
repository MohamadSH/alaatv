#!/bin/bash

cd /home/alaa/project/sohrab/alaaTv
echo -e "x57par" | sudo -S service php7.2-fpm restart

#php artisan down
 # perform any migrations                                                                                
# php artisan migrate --force                                                                             
 php artisan clear-compile
 php artisan cache:clear                                                                                 
 php artisan route:clear
 php artisan config:clear
 echo -e "x57par" | sudo -S php artisan view:clear
# echo -e "x57par" | sudo -S php artisan view:cache                                
                                                                                                         
 echo -e "x57par" | sudo -S chown alaa:www-data -R /home/alaa/project/sohrab/alaaTv
 echo -e "x57par" | sudo -S chgrp -R www-data storage bootstrap/cache             
 echo -e "x57par" | sudo -S chmod -R ug+rwx storage bootstrap/cache               
                                                                                                         
# php artisan route:cache                                                                                 
# php artisan config:cache                                                                                
#php artisan up
