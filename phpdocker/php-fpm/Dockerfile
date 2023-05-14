FROM phpdockerio/php:8.2-fpm
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

ENV XDEBUG_MODE=coverage

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install git php-memcached php-xdebug make \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

