antic-api
=======

[![Build Status](https://travis-ci.org/likunyan/antic-api.svg?branch=master)](https://travis-ci.org/likunyan/antic-api)
<a href="https://github.styleci.io/repos/229091867"><img src="https://github.styleci.io/repos/229091867/shield?branch=master" alt="StyleCI"></a>
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/StyleCI/SDK.svg?style=flat-square)](https://scrutinizer-ci.com/g/StyleCI/SDK/code-structure)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/likunyan/antic-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/likunyan/antic-api/?branch=master)

[中文](https://github.com/likunyan/react/blob/master/README_zh.md).

Personal study project.

Use frontend and backend separation.

## Powered by

* Laravel 6
    * JWT
* React 16
* Material-UI 4

## Server

* Ubuntu 18.04 LTS
* Nginx 1.14.0(nginx-full)
* MySQL 5.7
* PHP 7.2
    
## Build

1. Laravel
    1. composer install
    2. cp .env.example .env
        * modify DB and other
    3. php artisan migrate
    4. php artisan passport:install
    5. php artisan key:generate
    6. php artisan storage:link
2. React
	1. npm install
	2. Build
        * development: npm run dev
        * Production: npm run prod
3. Web Server：php artisan serve

## Deploy

Learning -> PhpStorm(Coding) -> GitHub -> WebHook -> Linux Server -> Customize Build(Filter) -> Slack Notification

## Something

- webpack-bundle-analyzer
- [Laravel IDE Helper Generator](https://github.com/barryvdh/laravel-ide-helper)

## Attention something

- [Tailwind CSS](https://next.tailwindcss.com/)
- [Next.js](https://nextjs.org)
- [Recharts](http://recharts.org)

## Note for myself

* http://gravatar.com/
* [SweetAlert2](https://sweetalert2.github.io/)
* axios, moment, lodash or others library what look at package.json please
* Material-UI
* Slack notification
    - [pagination](https://github.com/szmslab/material-ui-flat-pagination)
    - [notistack](https://iamhosseindhv.com/notistack)
    - [wertarbyte](https://mui.wertarbyte.com)
    - [material-table](https://material-table.com/#/docs/features/remote-data)
    - Icon
        - [字体图标](https://material.io/resources/icons)
        - https://github.com/Templarian/MaterialDesign-React
        - https://dev.materialdesignicons.com/icons
        - [mdi-material-ui](https://github.com/TeamWertarbyte/mdi-material-ui)
        - https://templarian.github.io/@mdi/react/
        - https://github.com/levrik/mdi-react
        - https://materialdesignicons.com/
        - [Material Icons](https://material-ui.com/zh/components/material-icons/)
* React
    - [react-router-dom](https://reacttraining.com/react-router/)
    - [Redux]("https://redux.js.org/basics/usage-with-react)
    - Route Redux
    - [React Redux](https://react-redux.js.org/introduction/quick-start)
