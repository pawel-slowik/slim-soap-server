FROM php:8.2-fpm

RUN apt-get update

RUN apt-get install -y libxml2-dev \
    && docker-php-ext-install soap \
    && docker-php-ext-enable soap

RUN echo cgi.fix_pathinfo=0 > /usr/local/etc/php/conf.d/disable_cgi_fix_pathinfo.ini

RUN pecl install xdebug && docker-php-ext-enable xdebug

# for PHPStan
RUN echo memory_limit=-1 > /usr/local/etc/php/conf.d/disable_memory_limit.ini

# for Composer
RUN apt-get install -y unzip

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
