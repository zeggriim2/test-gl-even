#---VARIABLES---------------------------------#

#---DOCKER---#
DOCKER_COMPOSE = docker compose
DOCKER_COMPOSE_UP = $(DOCKER_COMPOSE) up -d
DOCKER_COMPOSE_STOP = $(DOCKER_COMPOSE) stop
#------------#

#---PHP---#
PHP_CONSOLE = php bin/console
#------------#

#---SYMFONY--#
SYMFONY = symfony
SYMFONY_SERVER_START = $(SYMFONY) serve -d
SYMFONY_SERVER_STOP = $(SYMFONY) server:stop
#------------#
## === 🆘  HELP ==================================================
help: ## Show this help.
	@echo "Symfon-Makefile"
	@echo "---------------------------"
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
#---------------------------------------------#

## === 🐋  DOCKER ================================================
docker-up: ## Start docker containers.
	$(DOCKER_COMPOSE_UP)
.PHONY: docker-up

docker-stop: ## Stop docker containers.
	$(DOCKER_COMPOSE_STOP)
.PHONY: docker-stop
#---------------------------------------------#

## === 🎛️  SYMFONY ===============================================
sf-start: ## Start symfony server.
	$(SYMFONY_SERVER_START)
.PHONY: sf-start

sf-stop: ## Stop symfony server.
	$(SYMFONY_SERVER_STOP)
.PHONY: sf-stop
#---------------------------------------------#

## === 🔎  TESTS =================================================
tests: ## Run tests.
	$(PHP_CONSOLE) doctrine:database:drop --if-exists -f --env=test
	$(PHP_CONSOLE) doctrine:database:create --if-not-exists --env=test
	$(PHP_CONSOLE) doctrine:schema:update --force --env=test
	$(PHP_CONSOLE) doctrine:fixtures:load -n --env=test
	php bin/phpunit
.PHONY: tests
#---------------------------------------------#