FROM nginx:1.17.1-alpine as base

COPY public /Code/applications/shop/public
COPY public /Code/applications/dashboard/public

FROM base as dev

COPY shop_dev.conf /etc/nginx/conf.d/shop.conf
COPY dashboard_dev.conf /etc/nginx/conf.d/dashboard.conf

FROM base as prod

COPY shop_prod.conf /etc/nginx/conf.d/shop.conf
COPY dashboard_prod.conf /etc/nginx/conf.d/dashboard.conf


