<?php
    namespace Controllers;

    use Model\Regalo;
    use Model\Registro;

    class APIRegalo {
        public static function index() {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $regalos = Regalo::all();

            foreach($regalos as $regalo) {
                $regalo->total = Registro::totalArray(['id_regalo' => $regalo->id, 'id_paquete' => "1"]);
            }

            echo json_encode($regalos);
            return;
        }
    }