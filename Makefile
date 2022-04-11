start:
	php artisan serve --host 0.0.0.0
test:
	php artisan test

deploy:
	git push heroku

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests
log:
	tail -f storage/logs/laravel.log
install:
	composer install --no-scripts
