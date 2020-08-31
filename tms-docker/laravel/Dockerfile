FROM lindynetech/centos7-composer-php7:latest AS laravel
ARG TMS_PATH=/var/www/html/tms.com
RUN mkdir -p $TMS_PATH && \
    git clone https://github.com/lindynetech/tms2.git $TMS_PATH
COPY ./.env $TMS_PATH
WORKDIR $TMS_PATH
RUN composer install && \
    php artisan key:generate --force && \
    php artisan config:cache

FROM centos:latest AS production
ARG TMS_PATH=/var/www/html/tms.com
RUN mkdir -p $TMS_PATH
WORKDIR $TMS_PATH
COPY --from=laravel $TMS_PATH .
#CMD ["/bin/bash"]
