coverage := --coverage-html build/coverage-report
env := APP_ENV=test
phpunit := ./vendor/bin/phpunit
paratest := ./vendor/bin/paratest

install: composer.lock
	@composer install

update:
	@composer update

test: $(paratest)
	$(env) $(paratest) --processes=16 --runner=WrapperRunner $(coverage)

test-all: $(phpunit)
	$(env) $(phpunit) $(coverage)

test-fast: $(phpunit)
	$(env) $(phpunit) --exclude-group slow $(coverage)

test-slow: $(phpunit)
	$(env) $(phpunit) --group slow $(coverage)

test-class: $(phpunit)
	$(env) $(phpunit) --verbose --testdox $(class) $(coverage)

test-method: $(phpunit)
	$(env) $(phpunit) --verbose --testdox --filter $(class) $(method) $(coverage)

.PHONY: clean
clean: ./var/
	@rm -f ./var/app*
	@rm -f ./var/cache/test/* -R
	@rm -f ./var/log/test.log

.PHONY: clean-all
clean-all: ./var/ ./build/
	@rm -f ./build/* -R
	@rm -f ./var/app*
	@rm -f ./var/cache/* -R
	@rm -f ./var/log/*.log