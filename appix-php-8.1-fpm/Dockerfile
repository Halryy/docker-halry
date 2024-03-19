FROM php:8.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    # Install curl extension dependencies
    libcurl4-openssl-dev \
    \
    # Install mcrypt extension dependencies
    libmcrypt-dev \
    libssl-dev \
    \
    # Install gd and iconv extension dependencies
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    \
    # Other (necessary for gd)
    pkg-config \
    patch \
    libzip-dev \
    \
    # Install intl extension dependencies
    g++ \
    libicu-dev \
    \
    # Install xml/xsl extension dependencies
    libxml2-dev \
    libxml++2.6-dev \
    libxslt1-dev \
    \
    # Install postgresql extension dependencies
    libpq-dev \
    \
    # ZMQ dependencies - For internal socket messaging
    git \
    libzmq3-dev \
    \
    # Geos dependencies
    cmake \
    libgeos-dev
    #\
    # Cleanup
    #&& rm -rf /var/lib/apt/lists/*

# Install mcrypt, APCU and mongodb using PECL
RUN MAKEFLAGS="-j $(nproc)" pecl install -f APCu-5.1.22
RUN MAKEFLAGS="-j $(nproc)" pecl install -f mcrypt-1.0.5
RUN MAKEFLAGS="-j $(nproc)" pecl install -f mongodb-1.15.0

# Install ZMQ
RUN git clone https://github.com/mkoppanen/php-zmq.git \
    && cd php-zmq \
    && phpize && ./configure \
    && make -j$(nproc) \
    && make install \
    && cd .. \
    && rm -rf php-zmq

# Install Geos
RUN curl http://download.osgeo.org/geos/geos-3.11.1.tar.bz2 -o geos.tar.bz2 \
    && tar -xjvf geos.tar.bz2 \
    && cd geos-3.11.1/ \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    && cd .. \
    && rm -rf geos-3.11.1 \
    && rm geos.tar.bz2

# Install Geos PHP-Bindings
RUN git clone https://git.osgeo.org/gitea/geos/php-geos.git \
    && cd php-geos \
    && ./autogen.sh \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    && cd .. \
    && rm -rf php-geos

RUN ldconfig

# Enable and configure PHP extensions
RUN docker-php-ext-enable apcu geos mcrypt mongodb zmq
RUN docker-php-ext-install -j$(nproc) curl intl mbstring mysqli opcache sockets xml xsl zip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) iconv gd

RUN docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql

# Docker www-data rights
RUN usermod -u 1000 www-data 
RUN groupmod -g 1000 www-data

# Gives the webserver user access rights to the default www directory
RUN chown -R www-data:www-data /var/www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
