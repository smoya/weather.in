install:
	bin/composer.phar install

specs:
	bin/phpspec run

integration-tests:
	@echo "CAUTION: This tests will connect to a 3rd party sites using api-keys."
	bin/phpunit
