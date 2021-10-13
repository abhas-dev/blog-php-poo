# Blog-PHP-OOP

Ce projet est un blog realisé avec un framework PHP from scratch, lors de ma
formation dans le but d'apprendre les bases du langage PHP, de l'Orienté Objet
paradigme et du patron de conception MVC.

## Prerequisite :

PHP 8, MySQL, Apache.

## Languages and libraries

This project is made with:

- PHP 8
- HTML5
- CSS3 + Bootstrap
- JS

Dependencies manager: Composer

PHP packages, included via Composer:

- Twig: 3.0,
- Symfony/Dotenv: 5.3,
- Bootstrap: 5,
- Phpmailer: 6.5

## Installation

1. Download project zip or clone it from git.
2. Unzip
3. Open terminal and get into the project folder  
   ` cd blog-php-poo`
4. Install dependencies with composer  
   `composer install `

## Database

1. Create a new MYSQL database
2. import blog_php_db.sql

### Environment Variables

1. Copy .env.dist and rename it in .env.
2. Customize variables as needed.

### Mail Sending

Configuration is in /src/Mails/Mail.php

1. TCP port to connect to is set on 1025.
2. Host is set to localhost.
