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

echo "limpa o banco de dados, Rodando migrations e seeders..."
php artisan migrate:fresh --seed

echo "Iniciando Laravel..."
php artisan serve --host=0.0.0.0 --port=8000