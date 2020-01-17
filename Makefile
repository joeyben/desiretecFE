.PHONY: install phpcs server test help optimize routes migrate

.DEFAULT_GOAL = help
PHP=php
NPM=npm
COMPOSER=composer
PORT?=3000

vendor: composer.json
	composer install

composer.lock: composer.json
	composer update

install: vendor composer.lock ## install vendor dependancies  fdq10613@molms.com

help: ## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

phpcs: ## PRS2 Validation
	./vendor/bin/phpcbf --extensions=php
	./vendor/bin/phpcs --extensions=php

server: ## Load phpMyAdmin server
	$(PHP) -S localhost:$(PORT) -t ../../phpMyAdmin

test: install
	$(PHP) ./vendor/bin/phpunit

optimize: install ## optimize
	$(PHP) artisan cache:clear & $(PHP) artisan config:clear & $(PHP) artisan route:clear & $(PHP) artisan view:clear

migrate: optimize ## migrate
	$(PHP) artisan migrate:refresh --seed

routes: optimize
	$(PHP) artisan laroute:generate

message: optimize ## messages.js add /* eslint-disable */
	$(PHP) artisan lang:js --no-lib resources/assets/js/utils/messages.js & php artisan lang:js public/js/messages.js


