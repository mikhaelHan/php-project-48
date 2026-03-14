# Установка зависимостей
install:
	composer install

# Запуск линтера
lint:
	composer lint
lint-fix:
	composer lint-fix

# Запуск тестов
test:
	mkdir -p build/logs
	composer exec --verbose phpunit tests -- --log-junit build/logs/junit.xml --coverage-clover build/logs/clover.xml
