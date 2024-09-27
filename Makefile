SHELL := /bin/bash
DOCKER_COMPOSE ?= docker compose
EXEC_COMMAND ?= ${DOCKER_COMPOSE} exec application
DB_EXEC_COMMAND ?= ${DOCKER_COMPOSE} exec database
PHPUNIT_TEST_PATH ?= tests/
COMPOSER_EXEC ?= composer
INSTALL_COMPOSER_COMMAND ?= ${EXEC_COMMAND} ${COMPOSER_EXEC} install

.phony: start create_volumes build up composer_install permissions copy_env_vars test phpunit lint help generate_requirements build_frontend

start: copy_env_vars create_volumes build up composer_install permissions generate_key npm_install build_frontend # Bootstrap and start the application (dev)
help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | sort | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done
build: # Build docker compose
	${DOCKER_COMPOSE} build
build_frontend: # Build frontend assets
	${EXEC_COMMAND} npm run build
npm_install: # Install npm packages
	${EXEC_COMMAND} npm install --loglevel=info
create_volumes: # Create docker volumes
	docker volume create --name=bdd-workshop-postgresql || true
up: # Start docker compose (in the background)
	docker compose up -d
down: # Stop docker compose
	docker compose down
composer_install: #install composer on docker container (use EXEC_COMMAND to run without docker compose)
	${INSTALL_COMPOSER_COMMAND}
bash: # access to bash on docker container (use EXEC_COMMAND to run without docker compose)
	${EXEC_COMMAND} bash
permissions: # set permissions on docker container (use EXEC_COMMAND to run without docker compose)
	${EXEC_COMMAND} setfacl -R -m u:www:rwX storage/
	${EXEC_COMMAND} setfacl -dR -m u:www:rwX storage/
copy_env_vars: # copy default env vars
	cp -n .env.example .env
test: create_test_database migration_test phpunit phpspec behat # run tests (use EXEC_COMMAND to run without docker compose, use PHPUNIT_TEST_PATH to run specific tests)
migration: # run migrations (use EXEC_COMMAND to run without docker compose)
	${EXEC_COMMAND} php artisan migrate
create_test_database: # create test database (use EXEC_COMMAND to run without docker compose)
	${DB_EXEC_COMMAND} psql -U main -c "CREATE DATABASE main_test" || true
	${MAKE} migration_test
migration_test: # run migrations for test (use EXEC_COMMAND to run without docker compose)
	${EXEC_COMMAND} php artisan migrate --env=testing --database=pgsql_test
phpunit: # run phpunit tests (use EXEC_COMMAND to run without docker compose, use PHPUNIT_TEST_PATH to run specific tests)
	${EXEC_COMMAND} php artisan test -d memory_limit=-1 ${PHPUNIT_TEST_PATH}
phpspec: # run phpspec tests (use EXEC_COMMAND to run without docker compose)
	${EXEC_COMMAND} php vendor/bin/phpspec run
behat: # run behat tests (use EXEC_COMMAND to run without docker compose)
	${EXEC_COMMAND} php -d memory_limit=-1 vendor/bin/behat
generate_key: # generate key for laravel (use EXEC_COMMAND to run without docker compose)
	${EXEC_COMMAND} php artisan key:generate --force
