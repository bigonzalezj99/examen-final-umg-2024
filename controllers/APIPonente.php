<?php
    namespace Controllers;

    use Model\Ponente;

    class APIPonente {
        public static function index() {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $ponentes = Ponente::all();
            echo json_encode($ponentes);
        }

        public static function ponente() {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if (!$id || $id < 1) {
                echo json_encode([]);
                return;
            }

            $ponente = Ponente::find($id);
            echo json_encode($ponente, JSON_UNESCAPED_SLASHES);
        }
    }