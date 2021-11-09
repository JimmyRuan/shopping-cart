
.PHONY: php-lint
php-lint:
	@php vendor/bin/phpstan analyze src

.PHONY: php-fix
php-fix:
	@php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php

.PHONY: phpunit
phpunit:
	@php ./vendor/bin/phpunit tests