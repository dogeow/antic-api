antic-api
=======

[![Build Status](https://travis-ci.org/likunyan/antic-api.svg?branch=master)](https://travis-ci.org/likunyan/antic-api)
<a href="https://github.styleci.io/repos/229091867"><img src="https://github.styleci.io/repos/229091867/shield?branch=master" alt="StyleCI"></a>
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/StyleCI/SDK.svg?style=flat-square)](https://scrutinizer-ci.com/g/StyleCI/SDK/code-structure)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/likunyan/antic-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/likunyan/antic-api/?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![github-stars-image](https://img.shields.io/github/stars/likunyan/antic-api.svg?label=github%20stars)](https://github.com/likunyan/html5-antic-api)
[![Donate](https://img.shields.io/badge/donate-paypal-blue.svg?style=flat-square)](https://paypal.me/likunyan?locale.x=zh_XC)

[English](README.md)

个人学习项目

使用前后端分离
    
## 构建

1. Laravel
    1. composer install
    2. cp .env.example .env
        * 修改 DB and other
    3. php artisan migrate
    5. php artisan key:generate
    6. php artisan storage:link
2. React
	1. npm install
	2. 构建
        * development: npm run dev
        * Production: npm run prod
3. Web 服务：php artisan serve

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
