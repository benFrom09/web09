<?php

use Framework\Database\Database;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

//middlewares

$middlewares = require __DIR__ .'/../app/middlewares/middlewares.php';
$middlewares($app);

//init database

new Database();

//APP ROUTES
$routes = require __DIR__ . '/../app/routes/routes.php';
$routes($app);

$app->run();

