
## Клонирование проекта

Создайте новый репозиторий на github (в примере /new-project-name/)
```
git clone --bare https://github.com/nikservik/skeleton.git new-project-name
cd new-project-name
git push --mirror https://github.com/nikservik/new-project-name.git
cd ../
rm -rf new-project-name
git clone https://github.com/nikservik/new-project-name.git
```

## Установка

Запустите `install`
* нужно будет ввести доступ к БД и url приложения
* сгенерируется новый ключ приложения
* сгенерируются ключи для jwt-auth
* установятся пакеты composer
* установятся пакеты npm и скомпилируется фронт
* создадутся таблицы в БД
* добавится суперадминистратор с емейлом *ser.nikiforov@gmail.com* и паролем *password*

### Что нужно настроить для пакетов
* Ключи для CloudPayments
* Добавить уведомление Receipt в ЛК CloudPayments
* Возможности для тарифов и локализации возможностей




