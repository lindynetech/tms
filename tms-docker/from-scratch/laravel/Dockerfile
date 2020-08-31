FROM centos:latest AS laravel
ARG TMS_PATH=/var/www/html/tms.com
RUN yum update -y && \
    yum install epel-release unzip git -y && \
    yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm -y && \
    yum install php73 -y && \
    yum install -y php73-php-xml php73-php-fpm php73-php-cli php73-php-gd php73-php-json php73-php-mbstring \
    php73-php-mcrypt php73-php-mysqlnd php73-php-opcache php73-php-pdo && \
    ln -s /usr/bin/php73 /usr/bin/php && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    mkdir -p $TMS_PATH && \
    git clone https://github.com/lindynetech/tms2.git $TMS_PATH
COPY ./.env $TMS_PATH
WORKDIR $TMS_PATH
RUN composer install && \
    php artisan key:generate && \
    php artisan config:cache

FROM centos AS production
ARG TMS_PATH=/var/www/html/tms.com
WORKDIR $TMS_PATH
COPY --from=laravel $TMS_PATH .
CMD ["/bin/bash"]
