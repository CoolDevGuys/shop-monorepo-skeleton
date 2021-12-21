current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: deps start

env-files:
	@echo 'Checking local env files...'
	@if [ ! -f .env.dashboard ]; then cp .env.dashboard.dist .env.dashboard; fi
	@if [ ! -f .env.shop ]; then cp .env.shop.dist .env.shop; fi

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
	@docker run --rm $(INTERACTIVE) --volume $(current-dir)Code:/app --user www-data:www-data \
		cooldevguys/php:composer-81 composer $(CMD) \
			--ignore-platform-reqs \
			--no-ansi --prefer-dist --optimize-autoloader

test: env-files
	docker exec cooldevguys-skeleton-store ./vendor/bin/phpunit --testsuite store
	docker exec cooldevguys-store ./vendor/bin/phpunit --testsuite shared
	docker exec cooldevguys-store ./vendor/bin/behat -p store_backend --format=progress -v
	docker exec cooldevguys-dashboard ./vendor/bin/phpunit --testsuite dashboard

run-tests: env-files
	mkdir -p Code/build/test_results/phpunit
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite store
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite dashboard
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite shared
	./vendor/bin/behat -p store_backend --format=progress -v

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
	@rm -rf Code/applications/*/*/var
	@docker exec cooldevguys-skeleton-dashboard ./applications/dashboard/bin/console cache:warmup
	@docker exec cooldevguys-skeleton-store ./applications/shop/bin/console cache:warmup

build-composer:
	docker build -f
