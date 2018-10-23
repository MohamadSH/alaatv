#!/bin/bash

echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chown alaa:www-data -R /home/alaa/alaatv
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chown alaa:www-data -R /home/alaa/alaatv/*
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chgrp -R www-data storage bootstrap/cache
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chgrp -R www-data storage/* bootstrap/cache/*
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chmod -R ug+rwx storage bootstrap/cache
echo -e "$(cat /home/alaa/deploy/.env)" | sudo -S chmod -R ug+rwx storage/* bootstrap/cache/*
