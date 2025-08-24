# FROM php:8.0-apache
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# RUN apt-get update && apt-get upgrade -y


FROM php:8.2-apache

# ติดตั้ง PostgreSQL extensions
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# กำหนดโหมด production
ENV APP_ENV=production

# Copy source code (กรณีไม่ใช้ volume mount)
WORKDIR /var/www/html   
COPY . .
# COPY ./src /var/www/html/

# ตั้งสิทธิ์ให้ Apache อ่านได้
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80





    
    
    
    





