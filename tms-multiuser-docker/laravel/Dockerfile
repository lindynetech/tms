FROM lindynetech/centos7-composer-php7:latest
ARG TMS_PATH=/var/www/html/tms.com
ENV PAT=d880679f154d91942b41125ca163550eddfa6b45
RUN mkdir -p $TMS_PATH && \
    git clone https://${PAT}:@github.com/lindynetech/tms-cloud.git $TMS_PATH
COPY ./.env ./setup.sh $TMS_PATH/
WORKDIR $TMS_PATH
RUN composer install && \
    php artisan key:generate --force && \
    php artisan config:cache && \
		chmod +x setup.sh
CMD ["./setup.sh"]
