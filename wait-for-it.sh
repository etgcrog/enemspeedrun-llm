#!/usr/bin/env bash
# Wait-for-it script para aguardar a inicialização do banco de dados antes de rodar as migrações.

set -e

host="$1"
port="$2"
shift 2
cmd="$@"

until nc -z "$host" "$port"; do
  echo "Esperando o banco de dados $host:$port estar pronto..."
  sleep 2
done

echo "Banco de dados está pronto. Executando aplicação..."
exec $cmd
