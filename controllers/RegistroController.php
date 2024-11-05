<?php
    namespace Controllers;

    use Model\Registro;
    use Model\Usuario;
    use Model\Paquete;
    use Model\Regalo;
    use Model\DetalleEventoRegistro;

    use Model\Categoria;
    use Model\Dia;
    use Model\Hora;
    use Model\Evento;
    use Model\Ponente;

    use MVC\Router;

    class RegistroController {
        public static function crear(Router $router) {
            if (!isAuth()) {
                header('Location: /');
                return;
            }

            // Verificar si el usuario ya está registrado.
            $registro = Registro::where('id_usuario', $_SESSION['id']);

            if(isset($registro) && ($registro->id_paquete === "3" || $registro->id_paquete === "2" )) {
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }

            if(isset($registro) && $registro->id_paquete === "1") {
                header('Location: /finalizar_registro/conferencias');
                return;
            }

            $router->render('registro/crear', [
                'titulo' => 'Finalizar registro'
            ]);
        }

        public static function gratuito() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isAuth()) {
                    header('Location: /login');
                    return;
                }

                // Verificar si el usuario ya está registrado.
                $registro = Registro::where('id_usuario', $_SESSION['id']);

                if (isset($registro) && $registro->id_paquete === "3") {
                    header('Location: /boleto?id=' . urlencode($registro->token));
                    return;
                }

                $token = substr(md5(uniqid(rand(), true)), 0, 8);
                
                // Creación del nuevo registro.
                $datos = [
                    'id_paquete' => 3,
                    'id_pago' => '',
                    'token' => $token,
                    'id_usuario' => $_SESSION['id']
                ];

                $registro = new Registro($datos);
                $resultado = $registro->guardar();

                if ($resultado) {
                    header('Location: /boleto?id=' . urlencode($registro->token));
                    return;
                }
            }
        }

        public static function boleto(Router $router) {
            // Validar la URL.
            $id = $_GET['id'];
            
            if (!$id || !strlen($id) === 8 ) {
                header('Location: /');
                return;
            }

            // Buscar en la Base de Datos.
            $registro = Registro::where('token', $id);

            if (!$registro) {
                header('Location: /');
                return;
            }

            // Llenar las tablas de referencia.
            $registro->usuario = Usuario::find($registro->id_usuario);
            $registro->paquete = Paquete::find($registro->id_paquete);

            $router->render('registro/boleto', [
                'titulo' => 'Asistencia a DevWebCamp',
                'registro' => $registro
            ]);
        }

        public static function pagar() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isAuth()) {
                    header('Location: /login');
                    return;
                }

                // Validar el POST no venga vacío.
                if (empty($_POST)) {
                    echo json_encode([]);
                    return;
                }

                // Crear un registro.
                $datos = $_POST;
                $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
                $datos['id_usuario'] = $_SESSION['id'];

                try {
                    $registro = new Registro($datos);
                    $resultado = $registro->guardar();

                    echo json_encode($resultado);
                } catch (\Throwable $th) {
                    echo json_encode([
                        'resultado' => 'error'
                    ]);
                }
            }
        }

        public static function conferencias(Router $router) {
            if (!isAuth()) {
                header('Location: /login');
                return;
            }

            // Validar que tenga el plan presencial.
            $id_usuario = $_SESSION['id'];
            $registro = Registro::where('id_usuario', $id_usuario);

            if(isset($registro) && $registro->id_paquete === "2") {
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }
            
            if($registro->id_paquete !== "1") {
                header('Location: /');
                return;
            }

            // Redireccionar a boleto virtual en caso de haber finalizado su registro.
            if(isset($registro->id_regalo) && $registro->id_paquete === "1") {
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }

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

            $regalos = Regalo::all('ASC');

            // Manejando el regsitro mediante POST.
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Revisar que el usuario esté autenticado.
                if(!isAuth()) {
                    header('Location: /login');
                    return;
                }

                $eventos = explode(',', $_POST['eventos']);

                if(empty($eventos)) {
                    echo json_encode(['resultado' => false]);
                    return;
                }

                // Obtener el registro de usuario
                $registro = Registro::where('id_usuario', $_SESSION['id']);

                if(!isset($registro) || $registro->id_paquete !== "1") {
                    echo json_encode(['resultado' => false]);
                    return;
                }

                $eventosArray = [];

                // Validar la disponibilidad de los eventos seleccionados.
                foreach($eventos as $id_evento) {
                    $evento = Evento::find($id_evento);

                    // Comprobar que el evento exista.
                    if(!isset($evento) || $evento->disponible === "0") {
                        echo json_encode(['resultado' => false]);
                        return;
                    }
                    $eventosArray[] = $evento;
                }

                foreach($eventosArray as $evento) {
                    $evento->disponible -= 1;
                    $evento->guardar();

                    // Almacenar el registro.
                    $datos = [
                        'id_evento' =>  (int) $evento->id,
                        'id_registro' => (int)  $registro->id
                    ];

                    $registroUsuario = new DetalleEventoRegistro($datos);
                    $registroUsuario->guardar();
                }

                // Almacenar el regalo.
                $registro->sincronizar(['id_regalo' => $_POST['id_regalo']]);
                $resultado = $registro->guardar();

                if($resultado) {
                    echo json_encode([
                        'resultado' => $resultado, 
                        'token' => $registro->token
                    ]);
                } else {
                    echo json_encode(['resultado' => false]);
                }

                return;
            }

            $router->render('registro/conferencias', [
                'titulo' => 'Elige Workshops y Conferencias',
                'eventos' => $eventosFormateados,
                'regalos' => $regalos
            ]);
        }
    }