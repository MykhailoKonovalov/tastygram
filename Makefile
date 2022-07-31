# build application
build:
	docker-compose -f docker-compose.yml build

# up application
up:
	docker-compose -f docker-compose.yml up -d

# first setup application by 1 command
run:
	docker-compose -f docker-compose.yml build
	docker-compose -f docker-compose.yml up -d
	docker-compose -f docker-compose.yml exec php composer install

# down application
down:
	docker-compose -f docker-compose.yml down