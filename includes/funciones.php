<?php
    function debuguear($variable) : string {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        exit;
    }

    // Escapar / sanitizar el HTML.
    function s($html) : string {
        $s = htmlspecialchars($html);
        return $s;
    }

    function paginaActual($path) : bool {
        return str_contains($_SERVER['PATH_INFO'] ?? '/', $path ) ? true : false;
    }

    // Función que revisa que el usuario esté autenticado.
    function isAuth() : bool {
        if (!isset($_SESSION)) session_start();

        return isset($_SESSION['nombre']) && !empty($_SESSION);
    }

    function isAdmin() : bool {
        if (!isset($_SESSION)) session_start();

        return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
    }

    function aosAnimacion() : void {
        $efectos = ['fade-up', 'fade-left', 'fade-right', 'flip-right', 'zoom-in', 'zoom-out', 'zoom-in-up', 'zoom-in-down'];
        $efecto = array_rand($efectos, 1);
        echo ' data-aos="' . $efectos[$efecto] . '" ';
    }