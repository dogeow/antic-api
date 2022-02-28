antic-api
=======

[![codecov](https://codecov.io/gh/likunyan/antic-api/branch/master/graph/badge.svg?token=QJ7RYCXO96)](https://codecov.io/gh/likunyan/antic-api)
[![Build Status](http://img.shields.io/travis/likunyan/antic-api/master.svg?style=flat-square&logo=travis)](https://travis-ci.org/likunyan/antic-api)
<a href="https://github.styleci.io/repos/229091867"><img src="https://github.styleci.io/repos/229091867/shield?branch=master" alt="StyleCI"></a>
[![Code Quality](https://scrutinizer-ci.com/g/likunyan/antic-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/likunyan/antic-api/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/likunyan/antic-api/badges/build.png?b=master)](https://scrutinizer-ci.com/g/likunyan/antic-api/build-status/master)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![github-stars-image](https://img.shields.io/github/stars/likunyan/antic-api.svg?label=github%20stars)](https://github.com/likunyan/html5-antic-api)
[![Donate](https://img.shields.io/badge/donate-paypal-blue.svg?style=flat-square)](https://paypal.me/likunyan?locale.x=zh_XC)

[中文](README.md)

## Intro

Personal study project.

Use frontend and backend separation.

## Build

1. Laravel
    1. composer install
    2. cp .env.example .env
        * modify DB and other
    3. php artisan migrate
    5. php artisan key:generate
    6. php artisan storage:link
2. React
    1. npm install
    2. Build
        * development: npm run dev
        * Production: npm run prod
3. Web Server：php artisan serve

## Powered by

* Laravel 8
    * JWT
* React 17
* Material-UI 5

## Server

* Ubuntu 20.04 LTS
* Nginx 1.14.0(nginx-full)
* MySQL 5.7
* PHP 7.4
