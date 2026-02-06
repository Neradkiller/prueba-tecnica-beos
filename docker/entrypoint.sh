#!/bin/sh
set -e

echo "Iniciando contenedor de Laravel..."

echo "Esperando a que PostgreSQL esté listo..."
until php -r "try { new PDO('pgsql:host=db;port=5432;dbname=laravel_db', 'root', 'secret'); } catch (PDOException \$e) { exit(1); }" > /dev/null 2>&1; do
  echo "La base de datos aún no está lista. Reintentando en 2 segundos."
  sleep 2
done
echo "Base de datos conectada exitosamente."

echo "Ejecutando migraciones..."
php artisan migrate --force

echo "Iniciando servidor FrankenPHP..."
exec php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000 --workers=4