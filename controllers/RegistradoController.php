<?php
    namespace Controllers;

    use Model\Registro;
    use Classes\Paginacion;

    use Model\Usuario;
    use Model\Paquete;
    use Model\Regalo;

    use MVC\Router;

    class RegistradoController {
        public static function index(Router $router) {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $paginaActual = $_GET['page'];
            $paginaActual = filter_var($paginaActual, FILTER_VALIDATE_INT);

            if (!$paginaActual || $paginaActual < 1) header('Location: /admin/registrados?page=1');

            $registrosPorPagina = 10;
            $totalRegistros = Registro::total();
            $paginacion = new Paginacion($paginaActual, $registrosPorPagina, $totalRegistros);

            if ($paginacion->totalPaginas() < $paginaActual) header('Location: /admin/registrados?page=1');

            $registros = Registro::paginar($registrosPorPagina, $paginacion->offset());
            
            foreach($registros as $registro) {
                $registro->usuario = Usuario::find($registro->id_usuario);
                $registro->paquete = Paquete::find($registro->id_paquete);
                $registro->regalo = Regalo::find($registro->id_regalo);
            }

            $router->render('admin/registrados/index',[
                'titulo' => 'Usuarios registrados',
                'registros' => $registros,
                'paginacion' => $paginacion->paginacion()
            ]);
        }
    }