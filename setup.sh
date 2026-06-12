#!/usr/bin/env bash
# ─── BarqawiCars — one-command local Docker setup ─────────────────────────────
# Run from project root: bash setup.sh
# Requires: Docker Desktop (or Docker Engine) with Compose

set -euo pipefail

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

info()    { echo -e "${GREEN}[setup]${NC} $*"; }
warn()    { echo -e "${YELLOW}[warn]${NC}  $*"; }
error()   { echo -e "${RED}[error]${NC} $*" >&2; exit 1; }

# ── Detect Docker ─────────────────────────────────────────────────────────────
command -v docker >/dev/null 2>&1 || error "Docker not found. Install Docker Desktop: https://docs.docker.com/desktop/install/windows-install/"

# ── Detect Compose (V2 plugin OR V1 standalone) ───────────────────────────────
if docker compose version >/dev/null 2>&1; then
    COMPOSE="docker compose"
elif command -v docker-compose >/dev/null 2>&1; then
    COMPOSE="docker-compose"
else
    error "Docker Compose not found. Open Docker Desktop, go to Settings → General and enable 'Use Docker Compose V2'."
fi

info "Using: $COMPOSE"
info "Starting BarqawiCars local environment..."

# ── Create .env from example if missing ───────────────────────────────────────
if [ ! -f .env ]; then
    warn ".env not found — copying from .env.example"
    cp .env.example .env
fi

# ── Build images and start services ───────────────────────────────────────────
info "Building Docker images (this takes a few minutes on first run)..."
$COMPOSE build --parallel

info "Starting containers..."
$COMPOSE up -d

# ── Wait for MySQL to be ready ────────────────────────────────────────────────
info "Waiting for MySQL to be ready..."
attempt=0
until $COMPOSE exec -T mysql mysqladmin ping -h localhost -u root -prootsecret --silent 2>/dev/null; do
    attempt=$((attempt + 1))
    if [ $attempt -ge 30 ]; then
        error "MySQL did not become healthy after 60 seconds. Check logs: $COMPOSE logs mysql"
    fi
    sleep 2
done
info "MySQL is up."

# ── Install Composer dependencies ─────────────────────────────────────────────
info "Installing PHP dependencies..."
$COMPOSE exec -T app composer install --no-interaction

# ── Generate APP_KEY if not already set ───────────────────────────────────────
APP_KEY_VALUE=$(grep -m1 "^APP_KEY=" .env | cut -d= -f2 || true)
if [ -z "$APP_KEY_VALUE" ]; then
    info "Generating APP_KEY..."
    $COMPOSE exec -T app php artisan key:generate
fi

# ── Run migrations ────────────────────────────────────────────────────────────
info "Running migrations..."
$COMPOSE exec -T app php artisan migrate --force

# ── Create storage symlink ────────────────────────────────────────────────────
info "Linking storage..."
$COMPOSE exec -T app php artisan storage:link --force 2>/dev/null || true

# ── Done ─────────────────────────────────────────────────────────────────────
echo ""
echo -e "${GREEN}✔ Setup complete!${NC}"
echo ""
echo "  App    → http://localhost"
echo "  Mail   → http://localhost:8025"
echo "  MySQL  → localhost:3307  (user: laravel / password: secret)"
echo ""
echo "  Useful commands:"
echo "    $COMPOSE logs -f app       # PHP-FPM logs"
echo "    $COMPOSE exec app bash     # open shell in app container"
echo "    $COMPOSE down              # stop all services"
