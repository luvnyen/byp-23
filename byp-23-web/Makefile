# Variables
ARTISAN = php artisan

# Targets
.PHONY: init run clear

default: clear migrate run

init:
	@composer install
	@$(ARTISAN) key:generate

run:
	@$(ARTISAN) serve --port=8001

clear:
	@composer dump-autoload
	@$(ARTISAN) clear-compiled
	@$(ARTISAN) optimize
	@$(ARTISAN) config:clear