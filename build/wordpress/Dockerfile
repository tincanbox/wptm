FROM wordpress:5

ENV TZ ${SERVER_TIMEZONE}
RUN echo "${TZ}" > /etc/timezone \
   && dpkg-reconfigure -f noninteractive tzdata

ARG WWWDATA_USERID
ARG WP_INSTALL_DIR

# Package
RUN apt-get update && \
    apt-get install -y  --no-install-recommends sudo ssl-cert && \
    rm -r /var/lib/apt/lists/*

# WP-cli
RUN curl -o /tmp/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x /tmp/wp-cli.phar
RUN mv /tmp/wp-cli.phar /usr/local/bin/wp

#----------
# Apache 
#----------
EXPOSE 80
EXPOSE 443

# SSL
# Changes User-ID before docker-entrypoint.sh
RUN usermod -u ${WWWDATA_USERID} www-data


ARG ENTRY_UPDATED=${ENTRY_UPDATED}
RUN echo """${ENTRY_UPDATED}"

# DONT include filename for overwriting.
COPY ./entrypoint.sh /opt/
RUN chmod +x /opt/entrypoint.sh

# Runs custom entrypoint.
ENTRYPOINT [ "/opt/entrypoint.sh" ] 
CMD [ "apache2-foreground" ]
