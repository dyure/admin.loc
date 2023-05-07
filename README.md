Админка Orchid. Учебный проект. Документация: https://orchid.software/ru/docs/
На 19 апреля 2023 года возможна установка только для laravel ^9:

1. composer create-project laravel/laravel admin.loc "9.\*" --prefer-dist
2. composer require orchid/platform
3. Создаем БД и прописываем настройки в .env
4. php artisan orchid:install
5. php artisan orchid:admin admin admin@admin.com password
6. php artisan serve
7. Запуск по адресу: http://admin.loc/admin/login
