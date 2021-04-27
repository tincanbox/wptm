#!/bin/bash

# Runs original entrypoint script without `exec "$@"`.
# @see https://github.com/docker-library/wordpress/issues/130#issuecomment-272198161
sed -i -e 's/^exec "$@"/#exec "$@"/g' /usr/local/bin/docker-entrypoint.sh
. /usr/local/bin/docker-entrypoint.sh

echo "======== WPTM ENTRYPOINT ========"

# Add your configurations here if you need.
echo "moving configurations..."
yes | cp -f /opt/config/apache/.htaccess .htaccess 2>/dev/null || :
yes | cp -f /opt/config/php/wordpress.ini /usr/local/etc/php/conf.d/wordpress.ini 2>/dev/null || :
#yes | cp -f /usr/local/etc/php/php.ini-production /usr/local/etc/php/conf.d/php.ini 2>/dev/null || :

# WP Config
yes | cp -f /opt/config/wordpress/EnvAdaptor.php "$WP_INSTALL_DIR""/EnvAdaptor.php" 2>/dev/null || :
yes | cp -f /opt/config/wordpress/env-redirect.php "$WP_INSTALL_DIR""/env-redirect.php" 2>/dev/null || :
yes | cp -f /opt/config/wordpress/wp-config.php "$WP_INSTALL_DIR""/wp-config.php" 2>/dev/null || :
php "$WP_INSTALL_DIR""/env-redirect.php"

# Copies cert files.
if [ -e "/opt/config/ssl/$SSL_CERT_FILE" ] && [ -e "/opt/config/ssl/$SSL_CERT_KEY_FILE" ] ; then
    echo "setting up SSL..."

    # Prepares ssl config file from default one.
    yes | cp -f /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-available/wordpress-ssl.conf || :

    # Replaces SSL file name.
    sed -i -r "s|^(\s+SSLCertificateFile\s+)(.*)$|\1/etc/ssl/private/$SSL_CERT_FILE|g" \
       /etc/apache2/sites-available/wordpress-ssl.conf || :
    sed -i -r "s|^(\s+SSLCertificateKeyFile\s+)(.*)$|\1/etc/ssl/private/$SSL_CERT_KEY_FILE|g" \
       /etc/apache2/sites-available/wordpress-ssl.conf || :

    # Moves volumed SSL cert and key defined in .env file.
    # Put your cert-key pair in ./config/ssl dir.
    yes | cp -f "/opt/config/ssl/$SSL_CERT_FILE" "/etc/ssl/private/$SSL_CERT_FILE" || :
    yes | cp -f "/opt/config/ssl/$SSL_CERT_KEY_FILE" "/etc/ssl/private/$SSL_CERT_KEY_FILE" || :
    chmod 0644 "/etc/ssl/private/$SSL_CERT_FILE" || :
    chmod 0644 "/etc/ssl/private/$SSL_CERT_KEY_FILE" || :

    # Finally, activates generated config.
    a2ensite wordpress-ssl
else
    echo "setting up without SSL..."
fi

# if `.initialized` file is touched,
# skips all initiation flow.
if [ ! -e .initialized ]; then
    # Changes stateful directory permissions
    echo "changing www-data permissions..."
    chown www-data:www-data "${WP_INSTALL_DIR}"
    chown -R www-data:www-data "${WP_INSTALL_DIR}/wp-content"
    chmod -R g+w "${WP_INSTALL_DIR}/wp-content"

    # All core configurations are initiated by docker's wordpress image.
    # Just installing the configurated wordpress.
    echo "Installing wordpress..."
    sudo -u www-data wp core install \
        --path=${WP_INSTALL_DIR} \
        --url=${WP_URL} \
        --title=${WP_TITLE} \
        --admin_user=${WP_ADMIN_USER} \
        --admin_password=${WP_ADMIN_PASSWORD} \
        --admin_email=${WP_ADMIN_EMAIL} 

    sudo -u www-data wp plugin install \
        --path=${WP_INSTALL_DIR} \
        ${WP_PLUGIN_LIST} \
        --activate &> /dev/null

    sudo -u www-data wp theme activate \
        --path=${WP_INSTALL_DIR} \
        ${WP_DEFAULT_THEME} \
        || true

    sudo -u www-data wp menu create "WPTM-DEFAULT" \
        --path=${WP_INSTALL_DIR} \
        || true

fi

touch .initialized

# execute CMD
echo "Running CMD = $@"
exec "$@"
