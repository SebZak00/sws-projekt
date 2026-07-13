# Używamy oficjalnego obrazu PHP z wbudowanym serwerem Apache
FROM php:8.2-apache

# Instalujemy wymagane pakiety systemowe (Node.js dla Vite, narzędzia dla Laravela)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm

# Instalujemy rozszerzenia PHP (w tym PDO MySQL)
RUN docker-php-ext-install pdo pdo_mysql zip

# Włączamy moduł Rewrite w Apache (niezbędne dla adresów URL w Laravelu)
RUN a2enmod rewrite

# Ustawiamy folder /public jako główny katalog serwera
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Kopiujemy wszystkie pliki projektu na serwer
COPY . /var/www/html/

# Pobieramy Composera i instalujemy paczki PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Instalujemy i budujemy paczki frontowe (Vite)
RUN npm install && npm run build

# Nadajemy uprawnienia dla Laravela do zapisywania logów i cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN touch database/database.sqlite
RUN touch database/database.sqlite
RUN chown -R www-data:www-data database