test:
	php bin/console doctrine:database:drop --if-exists -f --env=test
	php bin/console doctrine:database:create --if-not-exists --env=test
	php bin/console doctrine:schema:update --force --env=test
	php bin/console doctrine:fixtures:load -n --env=test
	php bin/phpunit