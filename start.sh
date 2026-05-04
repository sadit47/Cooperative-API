#!/bin/sh

echo "PORT is: $PORT"

if [ -z "$PORT" ]; then
  echo "PORT not set, fallback to 8080"
  PORT=8080
fi

php artisan serve --host=0.0.0.0 --port=$PORT