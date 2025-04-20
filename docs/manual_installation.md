# Manual installation instructions
So you are here... may god have mercy on your soul...

## Environment
### Docker
#### docker-compose.yaml

Copy (and adjust to your needs) 
the `docker-compose.yaml.dist` file to `docker-compose.yaml`:

```bash
cp docker-compose.yaml.dist docker-compose.yaml
```

#### Environment variables

Copy (and adjust to your needs)
the `.env.dist` file to `app/.env.local`:

```bash
cp .env.dist app/.env.local
```

#### Start containers
```bash
docker-compose up -d --build
```

### Symfony
#### Install dependencies
```bash
docker-compose exec php composer install
```

## Database
### Create database
```bash
docker-compose exec php bin/console doctrine:database:create --if-not-exists
```

### Migrate database
```bash
docker-compose exec php bin/console doctrine:migrations:migrate
```

## Data
### Sync database with MealDB API
```bash
docker-compose exec php bin/console app:sync-recipes
```
### Generate some comments for all recipes
```bash
docker-compose exec php bin/console app:generate-comments
```

### Run worker to automatically sync recipes

Right now, the worker is syncing database every 20 minutes.

```bash
docker-compose exec php bin/console messenger:consume
```
