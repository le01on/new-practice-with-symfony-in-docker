FROM php:7.4-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev

#RUN npm install
RUN apt-get update \
 && apt-get install --no-install-recommends -y \
 curl \
 apt-transport-https \
 ca-certificates \
 gnupg2 \
 && curl -s https://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add - \
 && echo "deb https://deb.nodesource.com/node_8.x jessie main" > /etc/apt/sources.list.d/nodesource.list \
# Install tools
 && apt-get update \
 && apt-get install --no-install-recommends -y \
 openssh-client \
 bzip2 \
 nodejs \
 npm \
 # Slim down image
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/man/?? /usr/share/man/??_*

# Show versions
RUN php -v
RUN node -v
RUN npm -v
RUN npm install
RUN npm install bootstrap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer selfupdate


RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu






WORKDIR /usr/src/app

#COPY apps/my-symfony-app /usr/src/app

#RUN chmod -R 777 .

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin