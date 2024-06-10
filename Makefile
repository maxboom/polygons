.PHONY: init run-integration-tests remove-media-cache-tests

install:
	./vendor/bin/sail composer install
	./vendor/bin/sail artisan migrate
queue:
	./vendor/bin/sail artisan queue:work
