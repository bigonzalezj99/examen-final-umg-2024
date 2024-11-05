<?php
    namespace Controllers;

    use Model\EventoHorario;

    class APIEvento {
        public static function index() {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $id_dia = $_GET['id_dia'] ?? '';
            $id_categoria = $_GET['id_categoria'] ?? '';

            $id_dia = filter_var($id_dia, FILTER_VALIDATE_INT);
            $id_categoria = filter_var($id_categoria, FILTER_VALIDATE_INT);

            if (!$id_dia || !$id_categoria) {
                echo json_encode([]);
                return;
            }

            // Consultar la Base de Datos.
            $eventos = EventoHorario::whereArray(['id_dia' => $id_dia, 'id_categoria' => $id_categoria]) ?? [];

            echo json_encode($eventos);
        }
    }