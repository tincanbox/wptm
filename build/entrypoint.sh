#!/bin/sh

echo "======== ENTRYPOINT ========"

# Debian
#usermod -u 33 www-data
# Alpine
#usermod -u 1000 www-data

echo $(pwd)
yes | cp -f /opt/config/.htaccess .htaccess
yes | cp -f /opt/config/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

#chmod -R www-data:www-data /var/www/html

exec "$@"