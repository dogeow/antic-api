antic-api
=======

[![Build Status](https://travis-ci.org/likunyan/antic-api.svg?branch=master)](https://travis-ci.org/likunyan/antic-api)
<a href="https://github.styleci.io/repos/229091867"><img src="https://github.styleci.io/repos/229091867/shield?branch=master" alt="StyleCI"></a>
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/StyleCI/SDK.svg?style=flat-square)](https://scrutinizer-ci.com/g/StyleCI/SDK/code-structure)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/likunyan/antic-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/likunyan/antic-api/?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

[中文](README_zh.md).

Personal study project.

Use frontend and backend separation.

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
