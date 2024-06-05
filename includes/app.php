<?php

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require __DIR__ .  '/funciones.php';
require __DIR__ . '/config/database.php';
//Conectarnos a la base de datos
$db = conectarDB();



ActiveRecord::setDB($db);

// $propiedad = new Propiedad;

// var_dump($propiedad);