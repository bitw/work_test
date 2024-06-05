FROM php:8.1-buster

WORKDIR /app
COPY . /app

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zip \
    unzip \
    supervisor

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-install mbstring exif pcntl bcmath gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j "$(nproc)" gd

RUN pecl install swoole
RUN docker-php-ext-enable swoole

RUN pecl install -f xdebug-3.3.1 \
    && apt-get update \
    && apt-get install -y  \
    && docker-php-ext-enable xdebug \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /usr/share/doc/* /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY supervisord.conf /etc/supervisor/conf.d/supervisor.conf
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

### Раскомментировать если потребуется nodejs
### например для автоперезагрузки сервера при изменении кода бэка (т.к. юзаем Octane)

ENV NODE_VERSION=20.11.1
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

CMD ["/usr/bin/supervisord", "-n"]
