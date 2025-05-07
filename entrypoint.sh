#!/usr/bin/env sh
set -e

# Se a variável WAIT_HOSTS estiver definida (via docker-compose), aguarde
if [ -n "$WAIT_HOSTS" ]; then
  echo "⏳ Aguardando serviços: $WAIT_HOSTS"
  /usr/local/bin/wait-for-it.sh $WAIT_HOSTS --timeout=60 --strict
  echo "✅ Serviços prontos!"
fi

# Aqui você pode rodar migrations/seeders, se quiser:
# php artisan migrate --force
# php artisan db:seed --force

# Finalmente executa o comando passado no CMD (php artisan serve ...)
exec "$@"
