FROM alexromer0/php:fpm-81 as dev

WORKDIR /Code

COPY ./scripts/app-entrypoint /usr/local/bin
COPY ./scripts/pre-entrypoint/ /usr/local/bin/pre-entrypoint/
COPY ./scripts/wait-for-it.sh /usr/local/bin/wait-for-it.sh

RUN chown -R root:www-data /usr/local/bin /usr/local/etc && chmod -R 775 /usr/local/etc && chown -R www-data:www-data /Code

USER www-data

ENTRYPOINT ["/usr/local/bin/app-entrypoint"]

FROM dev as prod

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ../../Code .

RUN composer install
