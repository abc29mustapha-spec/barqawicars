# ─── BarqawiCars — one-command local Docker setup (PowerShell) ───────────────
# Run from project root: .\setup.ps1
# Requires: Docker Desktop for Windows

$ErrorActionPreference = 'Stop'

function Write-Info  { Write-Host "[setup] $args" -ForegroundColor Green }
function Write-Warn  { Write-Host "[warn]  $args" -ForegroundColor Yellow }
function Write-Fail  { Write-Host "[error] $args" -ForegroundColor Red; exit 1 }

# ── Pre-flight checks ─────────────────────────────────────────────────────────
if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    Write-Fail "Docker not found. Install Docker Desktop: https://docs.docker.com/desktop/install/windows-install/"
}

# Test compose (V2 plugin — ships with Docker Desktop)
$composeOk = $false
try { docker compose version 2>&1 | Out-Null; $composeOk = $LASTEXITCODE -eq 0 } catch {}
if (-not $composeOk) {
    Write-Fail "Docker Compose not found. Open Docker Desktop → Settings → General → enable 'Use Docker Compose V2'."
}

Write-Info "Docker OK — $(docker --version)"
Write-Info "Starting BarqawiCars local environment..."

# ── Create .env from example if missing ───────────────────────────────────────
if (-not (Test-Path .env)) {
    Write-Warn ".env not found — copying from .env.example"
    Copy-Item .env.example .env
}

# ── Build images and start services ───────────────────────────────────────────
Write-Info "Building Docker images (first run takes a few minutes)..."
docker compose build --parallel
if ($LASTEXITCODE -ne 0) { Write-Fail "Build failed. Check the output above." }

Write-Info "Starting containers..."
docker compose up -d
if ($LASTEXITCODE -ne 0) { Write-Fail "docker compose up failed." }

# ── Wait for MySQL ────────────────────────────────────────────────────────────
Write-Info "Waiting for MySQL to be ready..."
$attempt = 0
do {
    $attempt++
    if ($attempt -gt 30) { Write-Fail "MySQL did not become healthy. Run: docker compose logs mysql" }
    Start-Sleep -Seconds 2
    $ping = docker compose exec -T mysql mysqladmin ping -h localhost -u root -prootsecret --silent 2>&1
} until ($LASTEXITCODE -eq 0)
Write-Info "MySQL is up."

# ── Install Composer dependencies ─────────────────────────────────────────────
Write-Info "Installing PHP dependencies..."
docker compose exec -T app composer install --no-interaction
if ($LASTEXITCODE -ne 0) { Write-Fail "composer install failed." }

# ── Generate APP_KEY if missing ───────────────────────────────────────────────
$envContent = Get-Content .env -Raw
if ($envContent -match 'APP_KEY=\s*$' -or $envContent -match 'APP_KEY=\r?\n') {
    Write-Info "Generating APP_KEY..."
    docker compose exec -T app php artisan key:generate
}

# ── Run migrations ────────────────────────────────────────────────────────────
Write-Info "Running migrations..."
docker compose exec -T app php artisan migrate --force
if ($LASTEXITCODE -ne 0) { Write-Fail "Migrations failed." }

# ── Storage symlink ───────────────────────────────────────────────────────────
Write-Info "Linking storage..."
docker compose exec -T app php artisan storage:link --force 2>&1 | Out-Null

# ── Done ─────────────────────────────────────────────────────────────────────
Write-Host ""
Write-Host "  Setup complete!" -ForegroundColor Green
Write-Host ""
Write-Host "  App    -> http://localhost"
Write-Host "  Mail   -> http://localhost:8025"
Write-Host "  MySQL  -> localhost:3307  (user: laravel / pass: secret)"
Write-Host ""
Write-Host "  Useful commands:"
Write-Host "    docker compose logs -f app     # PHP-FPM logs"
Write-Host "    docker compose exec app bash   # shell in app container"
Write-Host "    docker compose down            # stop all"
