<?php
    namespace Controllers;

    use Model\Categoria;
    use Model\Dia;
    use Model\Hora;
    use Model\Evento;
    use Model\Ponente;

    use MVC\Router;

    class PaginaController {
        public static function index(Router $router) {
            $eventos = Evento::ordenar('id_hora', 'ASC');

            $eventosFormateados = [];

            foreach ($eventos as $evento) {
                $evento->categoria = Categoria::find($evento->id_categoria);
                $evento->dia = Dia::find($evento->id_dia);
                $evento->hora = Hora::find($evento->id_hora);
                $evento->ponente = Ponente::find($evento->id_ponente);

                if ($evento->id_dia === "1" && $evento->id_categoria === "1") { // Si es viernes y conferencias.
                    $eventosFormateados['conferencias_v'][] = $evento;
                }

                if ($evento->id_dia === "2" && $evento->id_categoria === "1") { // Si es sábado y conferencias.
                    $eventosFormateados['conferencias_s'][] = $evento;
                }

                if ($evento->id_dia === "1" && $evento->id_categoria === "2") { // Si es viernes y workshops.
                    $eventosFormateados['workshops_v'][] = $evento;
                }

                if ($evento->id_dia === "2" && $evento->id_categoria === "2") { // Si es sábado y workshops.
                    $eventosFormateados['workshops_s'][] = $evento;
                }
            }

            // Obtener el total de cada bloque.
            $ponentesTotal = Ponente::total();
            $conferenciasTotal = Evento::total('id_categoria', 1);
            $workshopsTotal = Evento::total('id_categoria', 2);
            $asistentesTotal = 499;

            // Obtener todos los speakers.
            $ponentes = Ponente::all();

            $router->render('paginas/index', [
                'titulo' => 'Inicio',
                'eventos' => $eventosFormateados,
                'ponentesTotal' => $ponentesTotal,
                'conferenciasTotal' => $conferenciasTotal,
                'workshopsTotal' => $workshopsTotal,
                'asistentesTotal' => $asistentesTotal,
                'ponentes' => $ponentes
            ]);
        }

        public static function devwebcamp(Router $router) {
            $router->render('paginas/devwebcamp', [
                'titulo' => 'Sobre DevWebCamp'
            ]);
        }

        public static function paquetes(Router $router) {
            $router->render('paginas/paquetes', [
                'titulo' => 'Paquetes DevWebCamp'
            ]);
        }

        public static function conferencias(Router $router) {
            $eventos = Evento::ordenar('id_hora', 'ASC');
            $eventosFormateados = [];

            foreach ($eventos as $evento) {
                $evento->categoria = Categoria::find($evento->id_categoria);
                $evento->dia = Dia::find($evento->id_dia);
                $evento->hora = Hora::find($evento->id_hora);
                $evento->ponente = Ponente::find($evento->id_ponente);

                if ($evento->id_dia === "1" && $evento->id_categoria === "1") { // Si es viernes y conferencias.
                    $eventosFormateados['conferencias_v'][] = $evento;
                }

                if ($evento->id_dia === "2" && $evento->id_categoria === "1") { // Si es sábado y conferencias.
                    $eventosFormateados['conferencias_s'][] = $evento;
                }

                if ($evento->id_dia === "1" && $evento->id_categoria === "2") { // Si es viernes y workshops.
                    $eventosFormateados['workshops_v'][] = $evento;
                }

                if ($evento->id_dia === "2" && $evento->id_categoria === "2") { // Si es sábado y workshops.
                    $eventosFormateados['workshops_s'][] = $evento;
                }
            }

            $router->render('paginas/conferencias', [
                'titulo' => 'Conferencias & workshops',
                'eventos' => $eventosFormateados
            ]);
        }

        public static function error(Router $router) {
            $router->render('paginas/error', [
                'titulo' => 'Error 404, página no encontrada'
            ]);
        }
    }