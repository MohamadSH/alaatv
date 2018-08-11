.env:2

`TAG_API_URL=http://79.127.123.242/api/v1/rt/`

`MEDIANA_API_URL=http://37.130.202.188/api/select`

`HORIZON_PREFIX=alaaTvHorizon`

`QUEUE_DRIVER=redis`

`LOG_LEVEL=error`

`SESSION_DRIVER=redis`
 
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
stdout_logfile=/home/alaatv/worker.log
```
```$xslt
[program:horizon]
process_name=%(program_name)s
command=php /home/alaa/project/sohrab/alaaTv/artisan horizon
autostart=true
autorestart=true
user=forge
redirect_stderr=true
stdout_logfile=/home/alaatv/horizon.log
```

```
sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*
```

**Nginx Config**
```$xslt
        merge_slashes off;
        rewrite ^(.*?)//+(.*?)$ $1/$2 permanent;
        rewrite ^/(.*)/$ /$1 permanent;
```

**MariaDb config**

```
# Generated by Percona Configuration Wizard (http://tools.percona.com/) version REL5-20120208
# Configuration name server001 generated for sohrab.a.fard@gmail.com at 2018-05-11 23:20:38

[mysqld]


# GENERAL #
user                           = mysql
default-storage-engine         = InnoDB
socket                         = /var/run/mysqld/mysqld.sock
pid-file                       = /var/run/mysqld/mysqld.pid
port                           = 3306
basedir                        = /usr

bind-address                   = 127.0.0.1

# MyISAM #
key-buffer-size                = 32M
myisam-recover-options         = FORCE,BACKUP

# SAFETY #
max-allowed-packet             = 16M
max-connect-errors             = 1000000
skip-name-resolve
sql-mode                       = STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_AUTO_VALUE_ON_ZERO,NO_ENGINE_SUBSTITUTION,NO_ZERO_DATE,NO_ZERO_IN_DATE,ONLY_FULL_GROUP_BY
sysdate-is-now                 = 1
innodb                         = FORCE
innodb-strict-mode             = 1

# DATA STORAGE #
datadir                        = /var/lib/mysql/
tmpdir                         = /tmp

# BINARY LOGGING #
log-bin                        = /var/lib/mysql/mysql-bin
expire-logs-days               = 14
sync-binlog                    = 1

# CACHES AND LIMITS #
tmp-table-size                 = 32M
max-heap-table-size            = 32M
query-cache-type               = 0
query-cache-size               = 0
max-connections                = 2000
thread-cache-size              = 100
open-files-limit               = 65535
table-definition-cache         = 4096
table-open-cache               = 2048

# INNODB #
innodb-flush-method            = O_DIRECT
innodb-log-files-in-group      = 2
innodb-log-file-size           = 256M
innodb-flush-log-at-trx-commit = 1
innodb-file-per-table          = 1
innodb-buffer-pool-size        = 12G

# LOGGING #
log-error                      = /var/log/mysql/mysql-error.log
log-queries-not-using-indexes  = 1
slow-query-log                 = 1
slow-query-log-file            = /var/log/mysql/mysql-slow.log

#
# * Character sets
#
# MySQL/MariaDB default is Latin1, but in Debian we rather default to the full
# utf8 4-byte character set. See also client.cnf
#
character-set-server           = utf8mb4
collation-server               = utf8mb4_general_ci
```
replication:
https://www.digitalocean.com/community/tutorials/how-to-configure-a-galera-cluster-with-mariadb-10-1-on-ubuntu-16-04-servers

**mongo db**
https://www.digitalocean.com/community/tutorials/how-to-install-mongodb-on-ubuntu-16-04

*install php7.2*
```
sudo apt-get install -y php7.2 php7.2-cli php7.2-dev \
php7.2-pgsql php7.2-gd \
php7.2-curl php7.2-memcached \
php7.2-imap php7.2-mysql php7.2-mbstring \
php7.2-xml php7.2-zip php7.2-bcmath php7.2-soap \
php7.2-intl php7.2-readline

sudo apt-get install php7.2-dba php7.2-json php7.2-mysql php7.2-readline php7.2-fpm php7.2-imap php7.2-tidy
```
