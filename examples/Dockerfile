# Dockerfile — минимальный образ для локального просмотра проекта.
# Использует Apache + PHP, так как корневая страница — index.php.
#
# Сборка:  docker build -t wp-reload .
# Запуск:  docker run --rm -p 8080:80 wp-reload
# Открыть: http://localhost:8080/

FROM php:8.3-apache

# Копируем проект в корень веб-сервера
COPY . /var/www/html/

# Apache по умолчанию слушает 80 порт в этом образе
EXPOSE 80
