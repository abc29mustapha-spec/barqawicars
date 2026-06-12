# Deployment Guide — Contabo VPS

Production URL: **https://barqawi-cars.de**

---

## 1. Provision the VPS

Order a Contabo VPS (recommended: VPS S — 4 vCPU, 8 GB RAM, Ubuntu 22.04 LTS).

After provisioning, connect via SSH:
```bash
ssh root@YOUR_SERVER_IP
```

---

## 2. Initial server setup

```bash
# Create a non-root deploy user
adduser deploy
usermod -aG sudo deploy
rsync --archive --chown=deploy:deploy ~/.ssh /home/deploy

# Log in as the deploy user from now on
su - deploy
```

**Firewall (UFW):**
```bash
sudo ufw allow OpenSSH
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

---

## 3. Install Docker

```bash
curl -fsSL https://get.docker.com | sudo sh
sudo usermod -aG docker deploy
newgrp docker            # apply group without logout
docker --version         # verify
```

---

## 4. Clone the repository

```bash
mkdir -p /srv/barqawicars
cd /srv/barqawicars
git clone git@github.com:YOUR_ORG/barqawicars.git .
```

> Tip: add your server's SSH public key (`~/.ssh/id_ed25519.pub`) to your GitHub repository as a Deploy Key (read-only).

---

## 5. Configure the production `.env`

```bash
cp .env.example .env
nano .env   # or use vim
```

Minimum values to change:

```ini
APP_NAME=BarqawiCars
APP_ENV=production
APP_KEY=            # generated below
APP_DEBUG=false
APP_URL=https://barqawi-cars.de

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=barqawicars
DB_USERNAME=laravel
DB_PASSWORD=CHANGE_ME_STRONG_PASSWORD
DB_ROOT_PASSWORD=CHANGE_ME_ROOT_PASSWORD

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true

QUEUE_CONNECTION=database

CACHE_STORE=redis
REDIS_HOST=redis
REDIS_PORT=6379

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=smtp
MAIL_HOST=your.smtp.host
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_smtp_password
MAIL_FROM_ADDRESS=hello@barqawi-cars.de
```

Generate the APP_KEY:
```bash
docker compose -f docker-compose.prod.yml run --rm app php artisan key:generate --show
# Copy the output and paste it into .env as APP_KEY=
```

---

## 6. Obtain SSL certificates (Let's Encrypt)

```bash
sudo apt install -y certbot
sudo mkdir -p /var/www/certbot

# Temporarily allow port 80 through and obtain cert
sudo certbot certonly --standalone \
    -d barqawi-cars.de \
    -d www.barqawi-cars.de \
    --email your@email.com \
    --agree-tos \
    --no-eff-email
```

Certificates are saved to `/etc/letsencrypt/live/barqawi-cars.de/`.

`docker-compose.prod.yml` mounts them read-only into the nginx container — no extra steps needed.

**Auto-renewal (cron):**
```bash
(crontab -l 2>/dev/null; echo "0 3 * * * certbot renew --quiet && docker compose -f /srv/barqawicars/docker-compose.prod.yml exec nginx nginx -s reload") | crontab -
```

---

## 7. First deployment

```bash
cd /srv/barqawicars

# Build and start all production services
docker compose -f docker-compose.prod.yml up -d --build

# Check that everything started cleanly
docker compose -f docker-compose.prod.yml ps
docker compose -f docker-compose.prod.yml logs app
```

The `entrypoint.sh` runs automatically:
- Waits for MySQL to be ready
- Runs `php artisan migrate --force`
- Creates the storage symlink
- Caches config / routes / views
- Starts supervisord (php-fpm + 2x queue workers + scheduler)

Visit **https://barqawi-cars.de** — done.

---

## 8. Subsequent deployments

```bash
cd /srv/barqawicars

git pull origin main

docker compose -f docker-compose.prod.yml up -d --build app

# Optional: clear old cached views if Blade templates changed
docker compose -f docker-compose.prod.yml exec app php artisan view:clear
```

> The `app` service rebuild triggers a new `entrypoint.sh` run which re-runs migrations and refreshes caches automatically.

---

## 9. Git push-to-deploy (optional)

On the server, create a bare repo that triggers deployment on push:

```bash
mkdir -p /srv/git/barqawicars.git
cd /srv/git/barqawicars.git
git init --bare

cat > hooks/post-receive << 'EOF'
#!/bin/bash
set -e
GIT_WORK_TREE=/srv/barqawicars git checkout -f main
cd /srv/barqawicars
docker compose -f docker-compose.prod.yml up -d --build app
EOF

chmod +x hooks/post-receive
```

On your **local machine**, add the server as a remote:
```bash
git remote add contabo deploy@YOUR_SERVER_IP:/srv/git/barqawicars.git
```

Deploy with:
```bash
git push contabo main
```

---

## 10. Useful server commands

```bash
# View live logs
docker compose -f docker-compose.prod.yml logs -f app

# Open a shell in the production app
docker compose -f docker-compose.prod.yml exec app bash

# Run Artisan on production
docker compose -f docker-compose.prod.yml exec app php artisan tinker

# Restart just one service
docker compose -f docker-compose.prod.yml restart nginx

# Stop everything (data is preserved in Docker volumes)
docker compose -f docker-compose.prod.yml down

# Full teardown including volumes (DESTROYS DATA)
docker compose -f docker-compose.prod.yml down -v

# Monitor container resource usage
docker stats
```

---

## Services in production

| Service   | Role                                        |
|-----------|---------------------------------------------|
| `app`     | PHP-FPM + 2x queue workers + scheduler      |
| `nginx`   | HTTPS reverse proxy with SSL & security headers |
| `mysql`   | MySQL 8 database (persistent volume)        |
| `redis`   | In-memory cache (128 MB, allkeys-lru)       |

---

## Monitoring & maintenance

**Database backups (daily cron):**
```bash
(crontab -l 2>/dev/null; echo "0 2 * * * docker compose -f /srv/barqawicars/docker-compose.prod.yml exec -T mysql mysqldump -u root -p\$DB_ROOT_PASSWORD barqawicars | gzip > /srv/backups/barqawicars-\$(date +%Y%m%d).sql.gz") | crontab -
mkdir -p /srv/backups
```

**Check failed queue jobs:**
```bash
docker compose -f docker-compose.prod.yml exec app php artisan queue:failed
```

**Clear failed jobs:**
```bash
docker compose -f docker-compose.prod.yml exec app php artisan queue:flush
```
