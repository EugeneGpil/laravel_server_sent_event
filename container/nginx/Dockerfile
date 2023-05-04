ARG NGINX_VERSION=1.24
FROM nginx:${NGINX_VERSION}

ENV DEBIAN_FRONTEND=noninteractive

COPY default.conf /etc/nginx/conf.d/default.conf

RUN apt-get update &&\
    apt-get install nano -y &&\
    mkdir /var/www &&\
    touch /var/www/.barshrc &&\
    echo "umask 012\n" >> /var/www/.bashrc
