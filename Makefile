.PHONY: init run-integration-tests remove-media-cache-tests

install:
	docker-compose exec laravel.test bash -c "composer install"
	docker-compose down --volumes
	./vendor/bin/sail up --build -d
queue:
	./vendor/bin/sail artisan queue:work
migrate:
	./vendor/bin/sail artisan migrate
