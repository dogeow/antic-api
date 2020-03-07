antic-api
=======

[![Build Status](https://travis-ci.org/likunyan/antic-api.svg?branch=master)](https://travis-ci.org/likunyan/antic-api)
<a href="https://github.styleci.io/repos/229091867"><img src="https://github.styleci.io/repos/229091867/shield?branch=master" alt="StyleCI"></a>
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/StyleCI/SDK.svg?style=flat-square)](https://scrutinizer-ci.com/g/StyleCI/SDK/code-structure)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/likunyan/antic-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/likunyan/antic-api/?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

[English](README.md)

个人学习项目

使用前后端分离

## 驱动

* Laravel 6
    * JWT
* React 16
* Material-UI 4

## 服务器

* Ubuntu 18.04 LTS
* Nginx 1.14.0(nginx-full)
* MySQL 5.7
* PHP 7.2
    
## 构建

1. Laravel
    1. composer install
    2. cp .env.example .env
        * 修改 DB and other
    3. php artisan migrate
    4. php artisan passport:install
    5. php artisan key:generate
    6. php artisan storage:link
2. React
	1. npm install
	2. 构建
        * development: npm run dev
        * Production: npm run prod
3. Web 服务：php artisan serve

## 部署
学习 -> PhpStorm(编码) -> GitHub -> WebHook -> Linux Server -> Customize Build(过滤) -> Slack 通知

## 一些其他的

- webpack-bundle-analyzer
- [Laravel IDE Helper Generator](https://github.com/barryvdh/laravel-ide-helper)

## 关注

- [Tailwind CSS](https://next.tailwindcss.com/)
- [Next.js](https://nextjs.org)
- [Recharts](http://recharts.org)

## 我自己的备忘

* http://gravatar.com/
* [SweetAlert2](https://sweetalert2.github.io/)
* axios, moment, lodash，其他的库请见 package.json
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
