install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 app tests
test:
	composer run-script phpunit tests