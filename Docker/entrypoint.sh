#!/bin/sh

# On quitte immédiatement si une commande échoue
set -e

if [ ! -f "vendor/autoload.php" ]; then
    echo "Installation des dépendances (Fallback)..."
    composer install --no-progress --no-interaction --optimize-autoloader --no-dev
fi

if [ ! -f ".env" ]; then
    echo "Creating env file"
    cp .env.example .env
    if [ -n "$APP_KEY" ]; then
        sed -i "s|APP_KEY=.*|APP_KEY=$APP_KEY|" .env
    fi
fi

echo "Waiting for database ($DB_HOST:$DB_PORT)..."
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
    echo "Database is unavailable - sleeping"
    sleep 2
done
echo "Database is up!"

if ! grep -Eq '^APP_KEY=.+$' .env; then
    echo "Génération de la clé applicative..."
    php artisan key:generate
fi

# ---------------------------------------------------------------------
# MIGRATIONS : applique uniquement les migrations en attente.
# NE JAMAIS mettre --seed ou migrate:fresh/refresh ici : ce script tourne
# à CHAQUE démarrage du conteneur (crash, redeploy, restart...), et ces
# commandes suppriment ou dupliquent des données réelles à chaque fois.
# `migrate` seul est idempotent : s'il n'y a rien de nouveau, il ne fait rien.
# Seul le conteneur web migre, pour éviter que web + worker migrent en
# même temps au démarrage (condition de course).
# ---------------------------------------------------------------------
if [ "$CONTAINER_ROLE" != "worker" ]; then
    echo "Application des migrations en attente..."
    php artisan migrate --force

    echo "Nettoyage et mise en cache des configurations..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Droits d'accès
chmod -R 775 storage bootstrap/cache

# ---------------------------------------------------------------------
# CONTAINER_ROLE=worker → ce conteneur ne fait tourner que la queue.
# Par défaut (non défini) → conteneur web, lance FrankenPHP.
# Permet de séparer web et queue dans deux conteneurs indépendants
# (voir docker-compose.yml), plus fiable qu'un `&` en tâche de fond.
# ---------------------------------------------------------------------
if [ "$CONTAINER_ROLE" = "worker" ]; then
    echo "Démarrage du worker de queue..."
    exec php artisan queue:work --sleep=3 --tries=3 --max-time=3600
fi

echo "Démarrage de FrankenPHP..."
exec frankenphp run --config /app/Docker/Caddyfile