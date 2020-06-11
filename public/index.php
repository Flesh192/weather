<?php

require __DIR__.'/../vendor/autoload.php';

//load Dotenv to get access to .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$weatherGateway = new \App\Gateway\OpenweathermapGataway();
$smsSemderGateway = new \App\Gateway\RouteeSmsSenderGataway();
$app = new App\Console\SendWeatherCommand($weatherGateway, $smsSemderGateway);
$app->sendWeather();