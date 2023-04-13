# Variables
ARTISAN = php artisan
ENV_FILE = .env.example
COMPOSER_JSON = composer.json

# Targets
.PHONY: init run migrate test test-model clear

default: clear migrate run

init:
	@composer install
	@cp $(ENV_FILE) .env
	@$(ARTISAN) key:generate
	@$(ARTISAN) migrate:fresh --seed

run: clear migrate
	@$(ARTISAN) serve

migrate:
	@$(ARTISAN) migrate:fresh --seed

test:
	@$(ARTISAN) test

test-model:
	@$(ARTISAN) test --filter $(model)Test

clear:
	@composer dump-autoload
	@$(ARTISAN) clear-compiled
	@$(ARTISAN) optimize

class:
	@$(ARTISAN) make:custom-class $(class)

postman:
	@$(ARTISAN) make:postman