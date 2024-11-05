<?php
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/funciones.php';
    require __DIR__ . '/config/conexion.php';

    // Conexión a la BD.
    $db = conexion();
    $db->set_charset('utf8');

    use Model\ActiveRecord;

    ActiveRecord::setDB($db);