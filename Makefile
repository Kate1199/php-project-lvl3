start:
	php artisan serve --host 0.0.0.0
test:
	php artisan test

deploy:
	git push heroku

lint:
	phpcs
log:
	tail -f storage/logs/laravel.log
setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
