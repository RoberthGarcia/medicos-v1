<?php

require __DIR__ . '/../vendor/autoload.php';

// Use our manual Dotenv class
use Classes\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Classes\ActiveRecord;
ActiveRecord::setDB($db);

// Definir constantes
define('URL_ROOT', $_ENV['URL_ROOT'] ?? 'http://localhost:3000');
define('SITE_NAME', 'Médicos Oaxaca');
