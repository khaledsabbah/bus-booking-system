#Версия PHP
FROM php:8.1-fpm
#Дополнительные библиотеки
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev  && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip

RUN apt-get update && apt-get install -y libmagickwand-6.q16-dev --no-install-recommends \
 && ln -s /usr/lib/x86_64-linux-gnu/ImageMagick-6.8.9/bin-Q16/MagickWand-config /usr/bin \
 && pecl install imagick \
 && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini

#Установка  ДЕБАГЕРА
RUN apt-get update && apt-get install -y wget git unzip
#Настройка параметров PHP
ADD ./php.ini /usr/local/etc/php/php.ini
#Установка композера
RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash
RUN apt-get install --yes nodejs
RUN node -v
RUN npm -v
RUN npm i -g nodemon
RUN nodemon -v


#Рабочая папка
WORKDIR /var/www

#CMD ["./afterInstall.sh"]
