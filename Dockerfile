FROM php:8.1-cli-alpine

COPY . /src/xml_data_importer

WORKDIR /src/xml_data_importer
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install