FROM node:latest as frontend

RUN mkdir -p /public
COPY public/css /public/css
COPY public/js /public/js
COPY resources/sass /resources/sass
COPY resources/js /resources/js

COPY package.json webpack.mix.js yarn.lock /

WORKDIR /

RUN yarn install && yarn run production

FROM nginx:latest

COPY public /var/www/html/public
COPY --from=frontend /public/js /var/www/html/public/js/
COPY --from=frontend /public/css /var/www/html/public/css/
COPY --from=frontend /mix-manifest.json /var/www/html/public/mix-manifest.json
COPY .docker/app-nginx/default.conf /etc/nginx/conf.d/default.conf
COPY .docker/app-nginx/proxy.conf /etc/nginx/conf.d/custom_proxy.conf
COPY .docker/app-nginx/start.sh /root/start.sh
RUN chmod +x /root/start.sh

CMD ["/root/start.sh"]
