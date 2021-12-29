current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: env-files deps
	@docker-compose build

env-files:
	@echo 'Checking local env files...'
	@if [ ! -f Code/.env.dashboard ]; then cp Code/.env.dashboard.dist Code/.env.dashboard; fi
	@if [ ! -f Code/.env.shop ]; then cp Code/.env.shop.dist Code/.env.shop; fi

.PHONY: deps
deps: composer-install

.PHONY: composer-install
composer-install: CMD=install

.PHONY: composer-update
composer-update: CMD=update

.PHONY: composer-require
composer-require: CMD=require
composer-require: INTERACTIVE=-ti --interactive

.PHONY: composer-require-module
composer-require-module: CMD=require $(module)
composer-require-module: INTERACTIVE=-ti --interactive

.PHONY: composer
composer composer-install composer-update composer-require composer-require-module:
	@docker run -e ENABLE_XDEBUG=true --rm $(INTERACTIVE) --volume $(current-dir)Code:/app --user $(id -u):$(id -g) \
		alexromer0/php:composer-81 composer $(CMD) \
			--prefer-dist --optimize-autoloader --no-ansi

.PHONY: reload
reload: env-files
	@docker-compose restart

test: env-files
	@echo "Running unit/integration tests 🧪"
	docker exec -e APP_ENV=test -e APP_DEBUG=0 cooldevguys-skeleton-store ./vendor/bin/phpunit --testsuite store --colors=always
	docker exec -e APP_ENV=test -e APP_DEBUG=0 cooldevguys-skeleton-store ./vendor/bin/phpunit --testsuite shared --colors=always
	docker exec -e APP_ENV=test -e APP_DEBUG=0 cooldevguys-skeleton-dashboard ./vendor/bin/phpunit --testsuite dashboard --colors=always
	@echo "Running acceptance tests 👨🏽‍🔬"
	docker exec -e APP_ENV=test -e APP_DEBUG=0 cooldevguys-store ./vendor/bin/behat -p store_backend --format=progress -v

run-tests: env-files
	mkdir -p Code/build/test_results/phpunit
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite store
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite dashboard
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite shared
	./vendor/bin/behat -p store_backend --format=progress -v

.PHONY: linter
linter: env-files
	docker exec -e APP_ENV=dev -e  APP_DEBUG=1 --user $(id -u):$(id -g) cooldevguys-skeleton-shop bash -c "php applications/shop/bin/console cache:warmup && ./vendor/bin/phpstan analyse -c phpstan-shop.neon.dist --level=7"
	docker exec -e APP_ENV=dev -e APP_DEBUG=1 --user $(id -u):$(id -g) cooldevguys-skeleton-dashboard bash -c "php applications/dashboard/bin/console cache:warmup && ./vendor/bin/phpstan analyse -c phpstan-dashboard.neon.dist --level=7"

.PHONY: start
start: CMD=up -d

.PHONY: stop
stop: CMD=stop

.PHONY: destroy
destroy: CMD=down

.PHONY: doco
doco start stop destroy: env-files
	@docker-compose $(CMD)

rebuild: env-files
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start

ping-mysql:
	@docker exec cooldevguys-shared_mysql mysqladmin --user=root --password= --host "127.0.0.1" ping --silent

clean-cache:
	@rm -rf /Code/applications/*/var/cache/*
	@docker exec cooldevguys-skeleton-dashboard php applications/dashboard/bin/console cache:warmup
	@docker exec cooldevguys-skeleton-shop php applications/shop/bin/console cache:warmup
