.PHONY: help clear_cache fixtures schema_update schema_create db_drop db_create db_reset_dev test
.DEFAULT_GOAL=help
PHP=php
CONSOLE=$(PHP) bin/console
SCHEMA=doctrine:schema
DB=doctrine:database
ENV?=dev


help: ## aide
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

clear_cache: ## nettoyer le cache
	$(CONSOLE) cache:clear --env=$(ENV)

fixtures: schema_update ## recharger les fixtures
	$(CONSOLE) doctrine:fixtures:load

schema_update: ## mettre à jour le schema de la base de données
	$(CONSOLE) $(SCHEMA):update --force

schema_create: ## créer le schema de la base de données
	$(CONSOLE) $(SCHEMA):create

db_drop: ## détruire la base de données
	$(CONSOLE) $(DB):drop --force

db_create: ## créer la base de données
	$(CONSOLE) $(DB):create

db_reset_dev: db_drop db_create schema_create fixtures ## recharger la base de données à neuf

test: ## lance les tests unitaires
	$(PHP) ./vendor/bin/phpunit

