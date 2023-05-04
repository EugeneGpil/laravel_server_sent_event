FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

ARG PHP_VERSION=8.2
ARG COMPOSER_VERSION=2.5
ARG ID_USER=1000
ARG ID_GROUP=1000
RUN groupadd -g ${ID_GROUP} app &&\
    useradd -u ${ID_USER} -m app -g app &&\
    usermod -a -G www-data app &&\
    apt-get update &&\
    mkdir /var/www &&\
    touch /var/www/.barshrc &&\
    echo "umask 012\n" >> /var/www/.bashrc &&\
    apt-get install software-properties-common -y &&\
    add-apt-repository ppa:ondrej/php -y &&\
    apt-get update &&\
    apt-get install\
    		php${PHP_VERSION}\
            php${PHP_VERSION}-cli\
            php${PHP_VERSION}-common\
            php${PHP_VERSION}-opcache\
            php${PHP_VERSION}-mysql\
            php${PHP_VERSION}-mbstring\
            php${PHP_VERSION}-zip\
            php${PHP_VERSION}-gd\
            php${PHP_VERSION}-fpm\
            php${PHP_VERSION}-xml\
            php${PHP_VERSION}-curl\
            php${PHP_VERSION}-dev\
            php${PHP_VERSION}-intl\
            php${PHP_VERSION}-mongodb -y &&\
    echo "listen = 9000" >> /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf &&\
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer &&\
    composer self-update ${COMPOSER_VERSION}

ARG INSTALL_XDEBUG=false
ARG PHP_VERSION=8.2
ARG PORT_XDEBUG=9051
ARG DOCKERHOST=172.17.0.1
RUN if [ "$INSTALL_XDEBUG" = "true" ] ; then \
        apt-get install php${PHP_VERSION}-xdebug -y && \
        echo "\n\
            xdebug.client_host=${DOCKERHOST}  \n\
            xdebug.client_port=${PORT_XDEBUG} \n\
            xdebug.mode=debug \n\
            xdebug.start_with_request=1 \n\
        " >> /etc/php/${PHP_VERSION}/fpm/conf.d/20-xdebug.ini && \
        echo "\n\
            zend_extension=xdebug \n\
            xdebug.mode=debug \n\
            xdebug.client_port=${PORT_XDEBUG} \n\
            xdebug.discover_client_host=1 \n\
            xdebug.client_host=localhost \n\
            xdebug.start_with_request=1 \n\
        " >> /etc/php/${PHP_VERSION}/cli/php.ini \
    ; fi
