FROM php:7.4-fpm-alpine

RUN apk add --update --no-cache \
        make \
        git \
        icu-libs \
        imagemagick \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        imagemagick-dev \
        libxml2-dev \
    && docker-php-ext-install \
        bcmath \
        intl \
        opcache \
        pcntl \
        soap \
        sockets \
    && pecl install \
        apcu \
        imagick \
        xdebug \
    && docker-php-ext-enable \
        apcu \
        imagick \
        xdebug \
    && apk del --purge .build-deps \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN mkdir /var/composer
ENV COMPOSER_HOME /var/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT=-1

ENTRYPOINT []

WORKDIR /usr/src/app

COPY . /usr/src/app

CMD ["php-fpm", "-F", "-R"]

