<?php
    function conexion() : mysqli {
        $localhost = 'localhost';
        $root = 'root';
        $contra = '';
        $base = 'dev_web_camp';

        $db = new mysqli($localhost, $root, $contra, $base);

        if(!$db) {
            echo '¡No fue posible conectar con la Base de Datos!';
            exit;
        }

        // Caso contrario que retorne una instancia de la conexión.
        return $db;
    }