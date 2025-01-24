FROM php:8.1-apache

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Actualizar e instalar dependencias necesarias
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
      procps \
      nano \
      git \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      supervisor \
      cron \
      sudo \
      libzip-dev \
      && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
      && docker-php-ext-configure intl \
      && docker-php-ext-install \
      pdo \
      pdo_mysql \
      mysqli \ 
      sockets \
      intl \
      opcache \
      zip \
      && pecl install xdebug \
      && docker-php-ext-enable xdebug \
      && apt-get clean \
      && rm -rf /tmp/* /var/lib/apt/lists/*

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Instalar phpDocumentor
COPY --from=phpdoc/phpdoc /opt/phpdoc/bin/phpdoc /usr/local/bin/phpdoc

# Instalar PHPUnit globalmente
RUN composer global require phpunit/phpunit && ln -s /var/www/html/vendor/bin/phpunit /usr/local/bin/phpunit

# Copiar archivo php.ini de desarrollo como configuración inicial
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
    echo "extension=mysqli" >> /usr/local/etc/php/php.ini
