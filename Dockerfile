FROM php:7.4.13-fpm-alpine

WORKDIR /applications

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ bash icu-dev rabbitmq-c rabbitmq-c-dev \
    && pecl install amqp-1.9.4 \
    && pecl install apcu-5.1.18 \
    && pecl install xdebug \
    && docker-php-ext-install -j$(nproc) \
    bcmath \
    opcache \
    intl \
    pdo_mysql \
    && docker-php-ext-enable \
    amqp \
    apcu \
    opcache \
    xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY etc/php/ /usr/local/etc/php/
