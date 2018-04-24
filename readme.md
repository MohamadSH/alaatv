.env:

`MEDIANA_API_URL=http://37.130.202.188/api/select`

`HORIZON_PREFIX=alaaTvHorizon`

`QUEUE_DRIVER=redis`

**Install Horizon:**

Due to its usage of async process signals, Horizon requires PHP 7.1+.

```
composer require laravel/horizon

php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"
```

**Configuring Supervisor**

https://laravel.com/docs/5.6/queues

https://laravel.com/docs/5.6/horizon#deploying-horizon

`/etc/supervisor/conf.d/alaatv-queues`
```$xslt
[program:alaatv-queues]
process_name=%(program_name)s_%(process_num)02d
command=php /home/alaa/project/sohrab/alaaTv/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=alaa
numprocs=8
redirect_stderr=true
stdout_logfile=/home/alaa/project/sohrab/alaaTv/worker.log
```
```$xslt
[program:horizon]
process_name=%(program_name)s
command=php /home/alaa/project/sohrab/alaaTv/artisan horizon
autostart=true
autorestart=true
user=forge
redirect_stderr=true
stdout_logfile=/home/alaa/project/sohrab/alaaTv/horizon.log
```

```
sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*
```