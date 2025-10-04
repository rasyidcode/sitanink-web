# syntax=docker/dockerfile:1

FROM composer:latest AS composer_upstream
FROM php:8.0-apache AS php_upstream

FROM php_upstream AS base

# Update the image
RUN apt-get update && apt-get install -y \
    zip \
    git

# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Use the default development configuration
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY ./sitanik.conf /etc/apache2/sites-available

RUN a2dissite 000-default.conf && \
    a2ensite sitanik.conf

RUN a2enmod rewrite

# Install required php extensions
RUN set -eux; \
    install-php-extensions \
    intl \
    mysqli \
    gd \
    zip

COPY --from=composer_upstream --link /usr/bin/composer /usr/local/bin/composer

RUN groupadd --gid 1000 appuser && \
    useradd --uid 1000 --gid 1000 -m appuser

USER appuser

WORKDIR /srv/sitanik
