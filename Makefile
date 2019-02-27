.PHONY: help clear_cache cc fixtures schema_update su schema_create sc db_drop db_create db_diff db_migrate db_reset_dev dbr test security_check phpcsfixer messdetector composer_require_checker docker_up docker_down docker_php
.DEFAULT_GOAL=help
VBIN=./vendor/bin
CBIN=./bin
PHP=php
CONSOLE=$(PHP) $(CBIN)/console
SCHEMA=doctrine:schema
DB=doctrine:database
MIGRE=doctrine:migration
ENV?=dev


help: ## aide
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

clear_cache: ## nettoyer le cache
	$(CONSOLE) cache:clear --env=$(ENV)

cc: clear_cache ## alias de clear_cache

fixtures: schema_update ## recharger les fixtures
	$(CONSOLE) doctrine:fixtures:load --no-interaction --env=dev

schema_update: ## mettre à jour le schema de la base de données
	$(CONSOLE) $(SCHEMA):update --force

su: schema_update ## alias de schema_update

schema_create: ## créer le schema de la base de données
	$(CONSOLE) $(SCHEMA):create

sc: schema_create ## alias de schema_create

db_drop: ## détruire la base de données
	$(CONSOLE) $(DB):drop --force

db_create: ## créer la base de données
	$(CONSOLE) $(DB):create

db_diff:
	$(CONSOLE) $(MIGRE):diff

db_migrate:
	$(CONSOLE) $(MIGRE):migrate --no-interaction

db_reset_dev: db_drop db_create schema_create fixtures ## recharger la base de données à neuf

dbr: db_reset_dev ## alias de db_reset_dev

test: ## lance les tests unitaires
	$(PHP) $(VBIN)/phpunit

security_check: ## vérifier si les paquets installés ne posent pas de problème
	$(PHP) $(VBIN)/security-checker security:check ./composer.lock

phpcsfixer_dry: ## php-cs-fixer en dry-run
	$(PHP) $(VBIN)/php-cs-fixer fix ./src --dry-run --format=txt --rules=@Symfony,@PSR2,-no_extra_blank_lines --verbose --show-progress=dots

phpcsfixer_fix: ## php-cs-fixer en dry-run
	$(PHP) $(VBIN)/php-cs-fixer fix ./src --format=txt --rules=@Symfony,@PSR2,-no_extra_blank_lines --verbose --show-progress=dots

messdetector: ## php mess detector tool
	$(PHP) $(VBIN)/phpmd ./src/ html cleancode,codesize,controversial,design,naming,unusedcode --reportfile phpmd.html

composer_require_checker: ## composer-require-checker tool
	$(PHP) $(VBIN)/composer-require-checker check ./composer.json

docker_up: ## start docker services
	docker-compose up

docker_down: ## stop docker services
	docker-compose down

docker_php: ## enter in smallshop_php container
	docker-compose exec smallshop_php /bin/bash
