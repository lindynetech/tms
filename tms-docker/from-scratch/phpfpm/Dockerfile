FROM php:7.2-fpm

LABEL maintainer=lindynetech@gmail.com

RUN cp -a /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
    docker-php-ext-install pdo_mysql && \
    echo "extension=pdo_mysql.so" > /usr/local/etc/php/conf.d/pdo_mysql.ini

CMD chown -R www-data:www-data /var/www && php-fpm
	
    

