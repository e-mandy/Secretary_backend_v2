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
# ZONE MIGRATION : Nettoyage forcé et unique
# ---------------------------------------------------------------------
echo "Remplacement complet de la base de données..."
php artisan migrate:fresh --force --seed
# ---------------------------------------------------------------------

# Optimisations Laravel pour la production
echo "Nettoyage et mise en cache des configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Droits d'accès pour FrankenPHP / Nginx unit
chown -R unit:unit storage bootstrap/cache

# ✅ Queue worker en arrière-plan (Redirection des logs pour éviter de bloquer)
php artisan queue:work --sleep=3 --tries=3 --max-time=3600 > /dev/null 2>&1 &
echo "Queue worker démarré en arrière-plan."

# ✅ Lancement du serveur d'application (FrankenPHP)
echo "Démarrage de FrankenPHP..."
exec frankenphp run --config /app/Docker/Caddyfile