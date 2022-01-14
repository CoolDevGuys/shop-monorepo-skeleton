FROM nginx:1.17.1-alpine as base

COPY public /Code/applications/shop/public
COPY public /Code/applications/dashboard/public

FROM base as dev

COPY shop_dev.conf /etc/nginx/conf.d/shop_dev.conf
COPY dashboard_dev.conf /etc/nginx/conf.d/dashboard_dev.conf

FROM base as prod

COPY shop_dev.conf /etc/nginx/conf.d/shop_prod.conf
COPY dashboard_dev.conf /etc/nginx/conf.d/dashboard_prod.conf


