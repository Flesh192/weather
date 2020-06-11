### Instalation

##### System requirements:
 * PHP 7.2
 * Web server to run application
 * APC lib 
 
 To install APC lib https://www.php.net/manual/ru/apc.installation.php


#### Installation process:

Clone the repository. Go to the project dir.

Install all composer dependencies

```
    composer install
```

Clone the env-example file to .env, adjust the settings in it as you needed (default ones should work good).
```
    cp env-example .env
``` 

To set up sheduled running you need add this script call to crontab. Example of configuration:

```
    */10 * * * * /path/to/folder/public/index.php
``` 