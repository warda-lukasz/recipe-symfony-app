compose:
	cp docker-compose.yaml.dist docker-compose.yaml
envs:
	cp .env.dist app/.env.local
build:
	docker compose build
run:
	docker compose up -d
wait-for-db:
	@echo "Waiting for database..."
	@until docker compose exec -T mysql bash -c "MYSQL_PWD=recipe mysqladmin ping -h localhost -u recipe --silent"; do \
		echo "..."; \
		sleep 2; \
	done
	@echo "Database ready!"
install:
	docker compose exec php composer install
update:
	docker compose exec php composer update
database: wait-for-db
	docker compose exec php bin/console doctrine:database:create --if-not-exists
migrate:
	docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
sync:
	docker compose exec php bin/console app:sync-recipes
comments:
	docker compose exec php bin/console app:generate-comments
start-worker:
	docker compose exec php bin/console messenger:consume

create-db: sync comments
first: envs build run install database migrate create-db start-worker
first-defaults: compose first
refresh: build run update migrate sync
start: run start-worker
