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
	composer test
