#!/bin/bash
set -e

DB_HOST="${DB_HOST:-mysql}"
DB_PORT="${DB_PORT:-3306}"

# Wait for MySQL to accept connections
echo "[entrypoint] Waiting for database at ${DB_HOST}:${DB_PORT}..."
attempt=0
until bash -c "exec 3<>/dev/tcp/${DB_HOST}/${DB_PORT}" 2>/dev/null; do
    attempt=$((attempt + 1))
    if [ $attempt -ge 30 ]; then
        echo "[entrypoint] ERROR: Database not reachable after 60 seconds. Aborting."
        exit 1
    fi
    echo "[entrypoint] Still waiting... (${attempt}/30)"
    sleep 2
done
echo "[entrypoint] Database is ready."

# Generate APP_KEY if missing
if [ -z "${APP_KEY}" ]; then
    echo "[entrypoint] No APP_KEY found — generating one..."
    php artisan key:generate --force
fi

# Run database migrations
echo "[entrypoint] Running migrations..."
php artisan migrate --force

# Ensure storage symlink exists
php artisan storage:link --force 2>/dev/null || true

# Cache config/routes/views in production for performance
if [ "${APP_ENV}" = "production" ]; then
    echo "[entrypoint] Caching configuration for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "[entrypoint] Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
