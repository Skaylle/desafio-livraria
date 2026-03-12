#!/bin/sh

echo "Aguardando PostgreSQL..."

until pg_isready -h db -p 5432 -U postgres
do
  echo "PostgreSQL ainda não está pronto..."
  sleep 2
done

echo "PostgreSQL pronto!"

echo "Instalando dependências..."
composer install

echo "Rodando migrations..."
php artisan migrate --force

echo "Rodando seeders..."
php artisan db:seed --force

echo "Iniciando Laravel..."
php artisan serve --host=0.0.0.0 --port=8000