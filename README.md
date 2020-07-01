![Master workflow](https://github.com/lev0607/php-project-lvl3/workflows/Master%20workflow/badge.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/55f0aac16a5c3530ee4e/maintainability)](https://codeclimate.com/github/lev0607/php-project-lvl3/maintainability)

# SEO Analyzer

## https://page--analyzer.herokuapp.com/
Учебный проект на фреймворке Laravel, который анализирует указанные страницы на SEO пригодность. Парсит при помощи библиотеки DiDOM и выводит по запрашиваемуму URL такую информацию как:
* status code
* h1
* description
* keywords

Требования : 
нельзя использовать модели Eloquent, только Query Builder. В обучающих целях поработать на уровне близком к sql-запросам.

* Фронтенд (Bootstrap, CDN)
* База данныx PostgreSQL, (Миграции, query builders)
* Логгирование
* Интеграционное тестирование с PHPUnit.
* Непрерывная интеграция (CI) c Github Actions (запуск линтера, тестов и проверка безопасности).
* Деплой на Heroku (PaaS).

