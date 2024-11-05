<?php
    namespace Controllers;

    use Model\Registro;
    use Model\Usuario;
    use Model\Evento;

    use MVC\Router;

    class DashboardController {
        public static function index(Router $router) {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            // Obtener últimos registros.
            $registros = Registro::get(5);

            foreach($registros as $registro) {
                $registro->usuario = Usuario::find($registro->id_usuario);
            }

            // Calcular los ingresos.
            $virtuales = Registro::total('id_paquete', 2);
            $presenciales = Registro::total('id_paquete', 1);

            // 46.41 y 189.54 es la cantidad que llega del depósito de PayPal ya sin comisiones.
            $ingresos = ($virtuales * 46.41) + ($presenciales * 189.54);

            // Obtener eventos con más y menos lugares disponibles.
            $menosDisponibles = Evento::ordenarLimite('disponible', 'ASC', 5);
            $masDisponibles = Evento::ordenarLimite('disponible', 'DESC', 5);

            $router->render('admin/dashboard/index',[
                'titulo' => 'Panel de administración',
                'registros' => $registros,
                'ingresos' => $ingresos,
                'menosDisponibles' => $menosDisponibles,
                'masDisponibles' => $masDisponibles
            ]);
        }
    }