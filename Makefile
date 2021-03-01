current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: deps start

env-file:
	@echo 'Checking local env file...'
	@if [ ! -f .env ]; then cp .env.dist .env; fi

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
composer composer-install composer-update composer-require composer-require-module: env-file
	@docker run --rm $(INTERACTIVE) --volume $(current-dir):/app --user $(id -u):$(id -g) \
		composer $(CMD) \
			--ignore-platform-reqs \
			--no-ansi --prefer-dist --optimize-autoloader

test: env-file
	docker exec cooldevguys-php_monorepo_skeleton-store_backend ./vendor/bin/phpunit --testsuite store
	docker exec cooldevguys-php_monorepo_skeleton-store_backend ./vendor/bin/phpunit --testsuite shared
	docker exec cooldevguys-php_monorepo_skeleton-store_backend ./vendor/bin/behat -p store_backend --format=progress -v
	docker exec cooldevguys-php_monorepo_skeleton-dashboard_backend ./vendor/bin/phpunit --testsuite dashboard

run-tests: env-file
	mkdir -p build/test_results/phpunit
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
doco start stop destroy: env-file
	@docker-compose $(CMD)

rebuild: env-file
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start

ping-mysql:
	@docker exec cooldevguys-php_monorepo_skeleton-shared_mysql mysqladmin --user=root --password= --host "127.0.0.1" ping --silent

clean-cache:
	@rm -rf applications/*/*/var
	@docker exec cooldevguys-php_monorepo_skeleton-dashboard_backend ./applications/dashboard/backend/bin/console cache:warmup
	@docker exec cooldevguys-php_monorepo_skeleton-dashboard_frontend ./applications/dashboard/frontend/bin/console cache:warmup
	@docker exec cooldevguys-php_monorepo_skeleton-store_backend ./applications/store/bin/console cache:warmup
