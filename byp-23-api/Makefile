# Variables
ARTISAN = php artisan
ENV_FILE = .env.example

# Targets
.PHONY: init run migrate test test-model clear

default: clear migrate run

init:
	@composer install
	@$(ARTISAN) key:generate
	@$(ARTISAN) migrate:fresh --seed

run:
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
	@$(ARTISAN) config:clear

class:
	@$(ARTISAN) make:custom-class $(class)

postman:
	@$(ARTISAN) make:postman