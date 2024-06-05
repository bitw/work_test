include .env

UID:=`id -u`
GID:=`id -g`
UIDS:=UID=${UID} GID=${GID}
PHP:=${UIDS} docker compose exec php
PG_VOLUME:=postgres_data

up:
	${UIDS} docker compose up -d

down:
	${UIDS} docker compose down --remove-orphans

restart: down up

bash:
	${PHP} bash

tinker:
	${PHP} php artisan tinker

stan:
	./vendor/bin/phpstan analyze --memory-limit=1G

pint-test:
	./vendor/bin/pint --test

pint-fix:
	./vendor/bin/pint
