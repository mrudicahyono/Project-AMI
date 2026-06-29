## Urutan menjalankan database seeder
1. 
```bash
php spark db:seed LembagaAkreditasiSeeder
```
2. 
```bash
php spark db:seed UserSeeder
```
3.
```bash
php spark db:seed ProdiSeeder
```
4.
```bash
php spark db:seed AuditorSeeder
```
4.
```bash
php spark db:seed FormEDSeeder
```



## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> The end of life date for PHP 7.4 was November 28, 2022.
> The end of life date for PHP 8.0 was November 26, 2023.
> If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> The end of life date for PHP 8.1 will be November 25, 2024.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

tes