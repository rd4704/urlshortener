# URL-Shortener
URL Shortener using bijective function that converts the base10 integer values to base62 equivalent to find an alphanumeric value for the shortened url that can be mapped to the original url in a database.

## Prerequisites
1. MySQL 5.5 and above
2. For testing PHPUnit phar file from https://phpunit.de/
3. mode_rewrite should be enabled on the server for neat urls

## Deployment
1. Import db_urlshortener.sql file to the mysql server
2. Place the source files on the server and make it accessible
3. Make sure .haccess file is placed in root directory with following rules
	RewriteEngine On
    RewriteRule (.*) index.php
