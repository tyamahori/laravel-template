SHELL=/bin/bash
.DEFAULT_GOAL := help

# user情報を取得する
USER_NAME := $(shell whoami)
USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)
DOCKER_COMPOSE_ENV := ./docker/mac/.env
COMPOSE_BASE_COMMAND := USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID) USER_NAME=$(USER_NAME) docker compose -f ./docker/mac/docker-compose.yml
PS_A := ps -a
COMPOSER_DIR := ./src/vendor
APP_SERVICE = app

.PHONY: help
help: # ref https://postd.cc/auto-documented-makefile/
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: dc-env
dc-env: ## Copy Docker compose env
dc-env: $(DOCKER_COMPOSE_ENV)
$(DOCKER_COMPOSE_ENV): ./docker/mac/.env
	cp ./docker/mac/.env.local ./docker/mac/.env

.PHONY: project-name
project-name: ## Get Project Name
project-name: dc-env
	COMPOSE_PROJECT_NAME=$(shell grep COMPOSE_PROJECT_NAME ./docker/mac/.env | cut -d '=' -f2 | head -1)

.PHONY: dc-build
dc-build: ## Build Docker Compose
dc-build: dc-env
	$(COMPOSE_BASE_COMMAND) down
	$(COMPOSE_BASE_COMMAND) $(PS_A)
	$(COMPOSE_BASE_COMMAND) build

.PHONY: dc-ps
dc-ps: ## Build Docker Compose
dc-ps: dc-env
	$(COMPOSE_BASE_COMMAND) ps -a

.PHONY: dc-up
dc-up: ## Docker Compose Up
dc-up:
	$(COMPOSE_BASE_COMMAND) down
	$(COMPOSE_BASE_COMMAND) up -d

.PHONY: dc-down
dc-down: ## Docker Compose down
dc-down:
	$(COMPOSE_BASE_COMMAND) down

.PHONY: dc-exec-app
dc-exec-app: ## Access Container
dc-exec-app:
	$(COMPOSE_BASE_COMMAND) exec -it app bash

.PHONY: dc-ide-helper
dc-ide-helper: ## Docker Compose down
dc-ide-helper:
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan ide-helper:generate
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan ide-helper:models --nowrite
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan ide-helper:meta
#	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/_ide_helper.php ./src/_ide_helper.php
#	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/_ide_helper_models.php ./src/_ide_helper_models.php
#	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/.phpstorm.meta.php ./src/.phpstorm.meta.php

.PHONY: rm-vendor-dir
rm-vendor-dir: ## Delete Vendor Directory
rm-vendor-dir:
	rm -rf $(COMPOSER_DIR)

.PHONY: dc-copy-vendor
dc-copy-vendor:  ## Copy Vendor Dir
dc-copy-vendor:
	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/vendor $(COMPOSER_DIR)

.PHONY: dc-logs
dc-logs: ## Docker Compose Logs
dc-logs:
	$(COMPOSE_BASE_COMMAND) logs -f

.PHONY: dc-ssh
dc-ssh: ## SSH Docker Container
dc-ssh:
	ssh-keygen -R localhost
	ssh-keygen -R 127.0.0.1
	ssh -oStrictHostKeyChecking=no -i ./docker/mac/ssh/localDocker -ND 9080 root@localhost

.PHONY: dc-phpunit
dc-phpunit: ## Run PHPUnit
dc-phpunit:
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) ./vendor/bin/phpunit

.PHONY: dc-phpstan
dc-phpstan: ## Run PHPStan
dc-phpstan:
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) composer ide-helper
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) composer phpstan

.PHONY: dc-cs-fixer
dc-cs-fixer: ## Run PHP-CS-Fixer
dc-cs-fixer:
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) ./vendor/bin/php-cs-fixer fix

.PHONY: dc-db-refresh
dc-db-refresh: ## Refresh Database
dc-db-refresh:
	$(COMPOSE_BASE_COMMAND) down
	docker volume rm tyamahori-db
	docker volume rm tyamahori-redis
	$(COMPOSE_BASE_COMMAND) up -d
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan migrate

.PHONY: dc-initialize
dc-initialize: ## Setup Docker Environment
dc-initialize:
	$(COMPOSE_BASE_COMMAND) down -v --rmi all --remove-orphans
#	rm -rf $(COMPOSER_DIR)
	$(COMPOSE_BASE_COMMAND) up -d
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) composer install
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan migrate:refresh --seed
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan ide-helper:generate
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan ide-helper:models --nowrite
	$(COMPOSE_BASE_COMMAND) exec -it $(APP_SERVICE) php artisan ide-helper:meta
	$(COMPOSE_BASE_COMMAND) ps -a
#	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/_ide_helper.php ./src/_ide_helper.php
#	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/_ide_helper_models.php ./src/_ide_helper_models.php
#	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/.phpstorm.meta.php ./src/.phpstorm.meta.php
#	$(COMPOSE_BASE_COMMAND) cp $(APP_SERVICE):/opt/projectWorkSpace/vendor $(COMPOSER_DIR)

# docker volume ls -f name=tyamahori | awk 'NR != 1 {print $2}' | xargs docker volume rm
