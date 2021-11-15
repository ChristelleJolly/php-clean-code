COMPOSE=docker-compose
CONTAINERS=workspace
GIT=git

help: ## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

env: ## Copy env file
	cd laradock && cp .env-example .env

install: ## Install containers and then install application
	cd laradock && cp .env.example .env
	cd laradock && $(COMPOSE) up -d --build $(CONTAINERS)

bash: ## Open bash shell on workspace container
	cd laradock && $(COMPOSE) exec --user=laradock workspace bash

up: ## Up containers
	cd laradock && $(COMPOSE) up -d $(CONTAINERS) $(SERVICES_API)

down: ## Down containers
	cd laradock && $(COMPOSE) down

rebuild: ## Rebuild containers
	cd laradock && $(COMPOSE) up -d --build --force-recreate $(CONTAINERS) $(SERVICES_API)

start: ## Start containers
	cd laradock && $(COMPOSE) start -d $(CONTAINERS) $(SERVICES_API)

stop: ## Stop containers
	cd laradock && $(COMPOSE) stop $(CONTAINERS) $(SERVICES_API)


.PHONY: help env install bash up down rebuild start stop
