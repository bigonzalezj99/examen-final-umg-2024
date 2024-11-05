<?php
    namespace Controllers;

    use Classes\Paginacion;
    use Model\Categoria;
    use Model\Dia;
    use Model\Hora;
    use Model\Evento;
    use Model\Ponente;
    use MVC\Router;

    class EventoController {
        public static function index(Router $router) {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $paginaActual = $_GET['page'];
            $paginaActual = filter_var($paginaActual, FILTER_VALIDATE_INT);

            if (!$paginaActual || $paginaActual < 1) header('Location: /admin/eventos?page=1');

            $porPagina = 10;
            $total = Evento::total();
            $paginacion = new Paginacion($paginaActual, $porPagina, $total);

            $eventos = Evento::paginar($porPagina, $paginacion->offset());

            foreach ($eventos as $evento) {
                $evento->categoria = Categoria::find($evento->id_categoria);
                $evento->dia = Dia::find($evento->id_dia);
                $evento->hora = Hora::find($evento->id_hora);
                $evento->ponente = Ponente::find($evento->id_ponente);
            }

            $router->render('admin/eventos/index',[
                'titulo' => 'Conferencias y workshops',
                'eventos' => $eventos,
                'paginacion' => $paginacion->paginacion()
            ]);
        }

        public static function crear(Router $router) {
            if (!isAdmin()) { 
                header('Location: /login');
                return;
            }

            $alertas = [];
            $categorias = Categoria::all('ASC');
            $dias = Dia::all('ASC');
            $horas = Hora::all('ASC');

            $evento = new Evento;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isAdmin()) { 
                    header('Location: /login');
                    return;
                }

                $evento->sincronizar($_POST);
                $alertas = $evento->validar();

                if (empty($alertas)) {
                    $resultado = $evento->guardar();

                    if ($resultado) { 
                        header('Location: /admin/eventos');
                        return;
                    }
                }
            }

            $router->render('admin/eventos/crear',[
                'titulo' => 'Registrar evento',
                'alertas' => $alertas,
                'categorias' => $categorias,
                'dias' => $dias,
                'horas' => $horas,
                'evento' => $evento
            ]);
        }

        public static function editar(Router $router) {
            if (!isAdmin()) { 
                header('Location: /login');
                return;
            }

            $alertas = [];

            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if (!$id) header('Location: /admin/eventos');

            $categorias = Categoria::all('ASC');
            $dias = Dia::all('ASC');
            $horas = Hora::all('ASC');

            $evento = Evento::find($id);

            if (!$evento) header('Location: /admin/eventos');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isAdmin()) { 
                    header('Location: /login');
                    return;
                }

                $evento->sincronizar($_POST);
                $alertas = $evento->validar();

                if (empty($alertas)) {
                    $resultado = $evento->guardar();

                    if ($resultado) {
                        header('Location: /admin/eventos');
                        return;
                    }
                }
            }

            $router->render('admin/eventos/editar',[
                'titulo' => 'Editar evento',
                'alertas' => $alertas,
                'categorias' => $categorias,
                'dias' => $dias,
                'horas' => $horas,
                'evento' => $evento
            ]);
        }

        public static function eliminar(Router $router) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isAdmin()) { 
                    header('Location: /login');
                    return;
                }

                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
                $evento = Evento::find($id);

                if (!isset($evento)) header('Location: /admin/eventos'); 

                $resultado = $evento->eliminar();

                if ($resultado) { 
                    header('Location: /admin/eventos');
                    return;
                }
            }
        }
    }