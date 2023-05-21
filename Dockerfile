FROM php:8.2-apache

# Installing Rust.
RUN apt-get update &&\
    apt-get install -y cargo

# Installing OPcache.
RUN set -eux; \
    docker-php-ext-configure opcache; \
    docker-php-ext-install opcache;
# Enabling OPcache and JIT.
RUN echo "opcache.enable=1" >> $PHP_INI_DIR/conf.d/opcache.ini &&\
    echo "opcache.jit=on" >> $PHP_INI_DIR/conf.d/opcache.ini

# Installing FFI.
RUN apt-get update &&\
    apt-get install -y libffi-dev &&\
    docker-php-ext-configure ffi --with-ffi &&\
    docker-php-ext-install ffi
# Configuring FFI to preload a given file.
RUN echo "ffi.enable=preload" > $PHP_INI_DIR/conf.d/ffi.ini &&\
    echo "opcache.preload=/var/www/html/preload.php" >> $PHP_INI_DIR/conf.d/ffi.ini

# WARNING! For development purposes only.
# Making www-data user match your user to be able to edit files mapped from your local system.
RUN usermod -u 1000 www-data

# Setting a user to be default apache user.
USER www-data
ENV USER=www-data

# Running.
CMD echo 'Building a library.' &&\
    # TODO: uncomment when library is created.
    cd /var/www/mylib &&\
    rustc --crate-type=cdylib -O -o ./mylib.so ./src/lib.rs &&\
    echo 'Starting apache' &&\
    # /usr/local/bin/docker-php-entrypoint &&\
    apache2-foreground
