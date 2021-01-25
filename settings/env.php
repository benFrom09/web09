<?php 

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['APP_NAME','DB_DRIVER','DB_NAME','DB_HOST','DB_USER','DB_PASS']);