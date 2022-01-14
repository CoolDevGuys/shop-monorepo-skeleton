FROM nginx:1.17.1-alpine as shop-base
COPY public /Code/applications/shop/public

FROM nginx:1.17.1-alpine as dashboard-base
COPY public /Code/applications/dashboard/public


FROM shop-base as shop-dev
COPY shop_dev.conf /etc/nginx/conf.d/shop.conf

FROM dashboard-base as dashboard-dev
COPY dashboard_dev.conf /etc/nginx/conf.d/dashboard.conf


FROM shop-base as shop-prod
COPY shop_prod.conf /etc/nginx/conf.d/shop.conf

FROM dashboard-base as dashboard-prod
COPY dashboard_prod.conf /etc/nginx/conf.d/dashboard.conf


