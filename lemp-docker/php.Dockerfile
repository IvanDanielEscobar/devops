# php.Dockerfile
# Usa la imagen base de PHP 8.2-FPM
FROM php:8.2-fpm

# Instala las extensiones PHP necesarias
# pdo_mysql es crucial para conectar con MySQL usando PDO
# mysqli es la que usabas antes, pero no está de más tenerla
# docker-php-ext-install es un script helper de la imagen oficial de PHP
RUN docker-php-ext-install pdo_mysql mysqli
