FROM nginx:latest

RUN rm -f /etc/nginx/conf.d/default.conf && mkdir -p /var/www/html/tms.com/public
COPY ./default.conf /etc/nginx/conf.d/

