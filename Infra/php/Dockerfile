FROM alexromer0/php:fpm-82 as dev

WORKDIR /Code

RUN chown -R www-data:www-data .

COPY ./Infra/php/scripts/app-entrypoint /usr/local/bin
COPY ./Infra/php/scripts/pre-entrypoint/ /usr/local/bin/pre-entrypoint/
COPY ./Infra/php/scripts/wait-for-it.sh /usr/local/bin/wait-for-it.sh

RUN chown -R root:www-data /usr/local/bin /usr/local/etc && chmod -R 775 /usr/local/etc

USER www-data

ENTRYPOINT ["/usr/local/bin/app-entrypoint"]

FROM dev as prod

USER root

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --chown=www-data:www-data ./Code .

USER www-data

RUN composer install
