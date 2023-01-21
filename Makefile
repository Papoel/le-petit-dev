# Paramètre
SHELL         = sh
PROJECT       = le-petit-dev
GIT_AUTHOR    = Papoel
HTTP_PORT     = 8000
HOST_NAME	  = 127.0.0.1
DB_NAME       = db_small_dev
DB_USER       = root
DB_PASS       = password
DB_PORT       = 3306
DB_SERVER     = MariaDB-10.11.1&charset=utf8mb4
DATABASE_URL  = \"mysql://$(DB_USER):$(DB_PASS)@$(HOST_NAME):$(DB_PORT)/$(DB_NAME)\"

# Executables
EXEC_PHP      = php
COMPOSER      = composer
YARN          = yarn

# Alias
SYMFONY       = $(EXEC_PHP) bin/console
SF            = symfony

# Executables: vendors
PHPUNIT       = ./vendor/bin/phpunit

# Executables: uniquement en local
SYMFONY_BIN    = symfony
BREW           = brew
DOCKER         = docker
DOCKER_COMPOSE = docker-compose
DOCKER_RUN     = docker run

## —— 🤞 The Papoel  Makefile 🤞 ——————————————————————————————————————————————————————————————————————————————
help: ## Affiche l'écran d'aide
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— SYMFONY BINAIRE 💻         —————————————————————————————————————————————————————————————————————————————————————
cert-install: ## Installez les certificats HTTPS locaux
	$(SYMFONY_BIN) server:ca:install
.PHONY: cert-install

serve: ## Servez l'application avec le support HTTPS (ajoutez "--no-tls" pour désactiver https)
	$(SYMFONY_BIN) serve --daemon --port=$(HTTP_PORT)
	$(eval CONFIRM := $(shell read -p "Faut-il exécuter le server Yarn ? [y/N] " CONFIRM && echo $${CONFIRM:-N}))
	$(SYMFONY_BIN) open:local
	@if [ "$(CONFIRM)" = "y" ]; then \
		$(YARN) dev-server; \
	fi
.PHONY: serve

unserve: ## Arrêtez le serveur web
	$(SYMFONY_BIN) server:stop
.PHONY: unserve

## —— SYMFONY 🎵                 ——————————————————————————————————————————————————————————————————————————————————————
sf: ## Lister toutes les commandes Symfony
	$(SYMFONY)
.PHONY: sf

cc: ## Videz le cache
	$(SYMFONY) cache:clear
	$(SYMFONY) cache:clear --no-warmup
	$(SYMFONY) cache:warmup
.PHONY: cc

purge: ## Purger le cache, supprimer les fichiers de log + les fichiers de coverage
	rm -rf var/cache/ var/log/ var/coverage && mkdir -p var/log && touch var/log/dev.log
	rm -rf .phpcs-cache
.PHONY: purge

## —— DOCKER 🐳                  ——————————————————————————————————————————————————————————————————————————————————————
up: ## Démarrer le hub docker (PHP,caddy,MySQL,redis,adminer,elasticsearch)
	$(DOCKER_COMPOSE) up --detach
.PHONY: up

down: ## Arrêtez le hub de docker
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: down

restart: ## Redémarrez le hub de docker
	$(DOCKER_COMPOSE) restart
.PHONY: restart

## —— PROJET 🚧                  ——————————————————————————————————————————————————————————————————————————————————————
start: up serve ## Démarrer le projet

stop: down unserve ## Arrêtez docker et le serveur Symfony

## —— DATABASE 💾                ——————————————————————————————————————————————————————————————————————————————————————
init-db-test: ## Initialiser la base de données de test
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:database:drop --force --if-exists
	$(SYMFONY) doctrine:database:create --env=test --if-not-exists
	$(SYMFONY) doctrine:schema:update --env=test --force
.PHONY: init-db-test

init-db-test-with-fixtures: ## Initialiser la base de données de test en chargeant les fixtures
	$(MAKE) init-db-test
	$(SYMFONY) doctrine:fixtures:load --no-interaction --env=test
.PHONY: init-db-test-with-fixtures

init-db-dev: ## Initialiser la base de données en environnement de développement
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:database:drop --force --if-exists
	$(SYMFONY) doctrine:database:create --env=dev --if-not-exists
	$(SYMFONY) doctrine:schema:update --env=dev --force
.PHONY: init-db-dev

## —— ENVIRONNEMENT ⭐           ——————————————————————————————————————————————————————————————————————————————————————

env-local: ## create .env.local file and set add DATABASE_URL
	touch .env.local
	@echo "DATABASE_URL=$(DATABASE_URL)" > .env.local
.PHONY: dev-env


env-test: ## Vérifie que le fichier .env.test existe, puis vérifie que DATABASE_URL est bien défini sinon on le créé
	file=.env.test; \
	if [ -f $$file ]; then \
		if grep -q "DATABASE_URL=$(DATABASE_URL)" $$file; then \
			echo "DATABASE_URL=$(DATABASE_URL) is already configured in $$file"; \
		else \
			echo "DATABASE_URL=$(DATABASE_URL)" >> $$file; \
		fi; \
	else \
		touch $$file; \
		echo "DATABASE_URL=$(DATABASE_URL)" >> $$file; \
	fi
.PHONY: env-test

show-env: ## Affiche les variables d'environnement
	$(SYMFONY) debug:dotenv
.PHONY: show-env

## —— TESTS 🧪                   ——————————————————————————————————————————————————————————————————————————————————————
tests: ## Exécuter les tests
	@echo "\n==> Exécution de tous les Tests (Unitaires et Fonctionnelles) <==\n"
	$(PHPUNIT) --testdox --verbose
.PHONY: tests
