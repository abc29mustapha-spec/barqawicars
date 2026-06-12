# BarqawiCars

Laravel 13 · PHP 8.3 · Vite 8 · Tailwind CSS 4 · Alpine.js

---

## Quick start — Docker (local dev)

```bash
# One command (requires Docker Desktop)
bash setup.sh
```

| Service   | URL                      |
|-----------|--------------------------|
| App       | http://localhost         |
| Mail UI   | http://localhost:8025    |
| MySQL     | localhost:3306           |

---

## Common Docker commands

```bash
# Start / stop all services
docker compose up -d
docker compose down

# View logs
docker compose logs -f              # all services
docker compose logs -f app          # PHP-FPM only
docker compose logs -f node         # Vite HMR

# Open a shell inside the app container
docker compose exec app bash

# Run Artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan tinker
docker compose exec app php artisan queue:work

# Rebuild images after Dockerfile changes
docker compose up -d --build

# Reset database (destroys data)
docker compose down -v && docker compose up -d
docker compose exec app php artisan migrate --seed
```

---

## Development workflow

```bash
# Run tests
docker compose exec app php artisan test

# Code formatting (Pint)
docker compose exec app ./vendor/bin/pint

# Clear caches after .env changes
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear

# Seed the database
docker compose exec app php artisan db:seed
```

---

## Switching between Herd and Docker

| | Herd | Docker |
|---|---|---|
| DB | SQLite (default) | MySQL |
| Queue | database | database |
| Cache | file | file |
| Mail | log | Mailpit (localhost:8025) |
| Vite HMR | native | port 5173 |

Docker env vars are set directly in `docker-compose.yml` — no `.env` changes needed for local dev.

---

## Production deployment

See [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) for full Contabo VPS setup.

```bash
# On the server
docker compose -f docker-compose.prod.yml up -d --build
```
