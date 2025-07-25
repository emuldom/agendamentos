#!/bin/bash
set -e

echo "🚀 Iniciando aplicação Laravel..."

# Aguardar PostgreSQL estar disponível
echo "⏳ Aguardando PostgreSQL..."
until php artisan migrate:status > /dev/null 2>&1; do
    echo "PostgreSQL não está pronto - aguardando..."
    sleep 2
done

# Aguardar Redis estar disponível
echo "⏳ Aguardando Redis..."
until php artisan tinker --execute="Redis::ping()" > /dev/null 2>&1; do
    echo "Redis não está pronto - aguardando..."
    sleep 2
done

echo "✅ Dependências prontas!"

# Executar migrações se necessário
if [ "$APP_ENV" = "production" ]; then
    echo "🔄 Executando migrações..."
    php artisan migrate --force
fi

# Limpar e otimizar cache
echo "🧹 Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "🎉 Aplicação pronta!"