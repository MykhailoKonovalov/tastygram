build:
	docker-compose -f api/compose.yaml build
	docker-compose -f api/compose.yaml up -d
	docker-compose -f api/compose.yaml exec php composer install
	docker-compose -f api/compose.yaml exec php php bin/console doctrine:database:create --if-not-exists
	docker-compose -f api/compose.yaml exec php php bin/console doctrine:migrations:migrate --no-interaction

up:
	docker-compose -f api/compose.yaml up -d

down:
	docker-compose -f api/compose.yaml down