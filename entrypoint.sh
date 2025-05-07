#!/bin/bash

echo "🚀 Aguardando MySQL iniciar..."
until nc -z -v -w30 mysql 3306
do
  echo "Aguardando banco de dados..."
  sleep 5
done

echo "✅ Banco de dados disponível!"

# Instala dependências, roda migrations, etc
composer install
php artisan migrate --force
php artisan db:seed --force
php artisan serve --host=0.0.0.0 --port=8000
