<?php

$db = new mysqli(
    $_ENV['DB_HOST'] ?? 'localhost',
    $_ENV['DB_USER'] ?? 'root',
    $_ENV['DB_PASS'] ?? '',
    $_ENV['DB_NAME'] ?? 'medicos_oaxaca'
);

if ($db->connect_error) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . $db->connect_errno;
    echo "error de depuración: " . $db->connect_error;
    exit;
}

$db->set_charset('utf8');

return $db;
