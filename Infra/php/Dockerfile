FROM cooldevguys/php:fpm-81 as dev

WORKDIR /Code

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY ./scripts/app-entrypoint /usr/local/bin
COPY ./scripts/pre-entrypoint/ /etc/pre-entrypoint/
COPY ./scripts/wait-for-it.sh /usr/local/bin/wait-for-it.sh
USER www-data

ENTRYPOINT ["/usr/local/bin/app-entrypoint"]

FROM dev as prod

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ../../Code .

RUN composer install
