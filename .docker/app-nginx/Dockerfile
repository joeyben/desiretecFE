FROM node:latest as frontend

RUN mkdir -p /public
RUN npm config set "@fortawesome:registry" https://npm.fontawesome.com/ && \
      npm config set "//npm.fontawesome.com/:_authToken" 872992B4-8894-4152-95B3-FAA83ECC14D4
COPY public/css /public/css
COPY public/js /public/js
COPY resources/sass /resources/sass
COPY resources/js /resources/js

COPY package.json webpack.mix.js yarn.lock /

WORKDIR /

RUN yarn install && yarn production

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
