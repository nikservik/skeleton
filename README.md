
## Установка

После установки сгенерируйте ключ приложения
`php artisan key:generate --ansi`

Сгенерируйте ключ для аутентификации в api
`php artisan jwt:secret`

Создайте базу данных и укажите доступ к ней в `.env`. По умолчанию `laravel@forge:forge`

Создайте таблицы в БД
`php artisan migrate`


