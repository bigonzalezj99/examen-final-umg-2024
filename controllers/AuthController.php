<?php
    namespace Controllers;

    use Classes\Correo;
    use Model\Usuario;
    use MVC\Router;

    class AuthController {
        public static function login(Router $router) {
            $alertas = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario = new Usuario($_POST);
                $alertas = $usuario->validarLogin();
                
                if (empty($alertas)) {
                    // Verificar que el usuario exista.
                    $usuario = Usuario::where('correo', $usuario->correo);

                    if (!$usuario || !$usuario->confirmado) {
                        Usuario::setAlerta('error', '¡El Usuario no existe o no está confirmado!');
                    } else {
                        // El Usuario existe.
                        if (password_verify($_POST['contrasena'], $usuario->contrasena)) {
                            // Iniciar la sesión.
                            session_start();
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre;
                            $_SESSION['apellido'] = $usuario->apellido;
                            $_SESSION['correo'] = $usuario->correo;
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            // Redirección.
                            if ($usuario->admin) {
                                header('Location: /admin/dashboard');
                            } else {
                                header('Location: /finalizar_registro');
                            }
                        } else {
                            Usuario::setAlerta('error', '¡La contraseña ingresada es incorrecta!');
                        }
                    }
                }
            }

            $alertas = Usuario::getAlertas();
            
            // Render a la vista.
            $router->render('auth/login', [
                'titulo' => 'Iniciar sesión',
                'alertas' => $alertas
            ]);
        }

        public static function logout() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                session_start();

                $_SESSION = [];
                header('Location: /');
            }
        }

        public static function registro(Router $router) {
            $alertas = [];
            $usuario = new Usuario;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario->sincronizar($_POST);
                $alertas = $usuario->validarNuevaCuenta();

                if (empty($alertas)) {
                    $existeUsuario = Usuario::where('correo', $usuario->correo);

                    if ($existeUsuario) {
                        Usuario::setAlerta('error', '¡El usuario ya se encuentra registrado!');
                        $alertas = Usuario::getAlertas();
                    } else {
                        // Hashear la contraseña.
                        $usuario->hashContrasena();

                        // Eliminar contrasena2.
                        unset($usuario->contrasena2);

                        // Generar el Token.
                        $usuario->crearToken();

                        // Crear un nuevo usuario.
                        $resultado = $usuario->guardar();

                        // Enviar correo electrónico.
                        $correo = new Correo($usuario->nombre, $usuario->apellido, $usuario->correo, $usuario->token);
                        $correo->enviarConfirmacion();

                        if ($resultado) {
                            header('Location: /mensaje');
                        }
                    }
                }
            }

            // Render a la vista.
            $router->render('auth/registro', [
                'titulo' => 'Crear cuenta',
                'usuario' => $usuario, 
                'alertas' => $alertas
            ]);
        }

        public static function olvide(Router $router) {
            $alertas = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario = new Usuario($_POST);
                $alertas = $usuario->validarCorreo();

                if (empty($alertas)) {
                    // Buscar el usuario.
                    $usuario = Usuario::where('correo', $usuario->correo);

                    if ($usuario && $usuario->confirmado) {
                        // Generar un nuevo token.
                        $usuario->crearToken();
                        unset($usuario->contrasena2);

                        // Actualizar el usuario.
                        $usuario->guardar();

                        // Enviar el correo electrónico.
                        $correo = new Correo( $usuario->nombre, $usuario->apellido, $usuario->correo, $usuario->token);
                        $correo->enviarInstrucciones();

                        // Imprimir la alerta.
                        // Usuario::setAlerta('exito', '¡Hemos enviado las instrucciones a su correo electrónico!');
                        $alertas['exito'][] = '¡Hemos enviado las instrucciones a su correo electrónico!';
                    } else {
                        // Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                        $alertas['error'][] = '¡El usuario no existe o no esta confirmado!';
                    }
                }
            }

            // Muestra la vista.
            $router->render('auth/olvide', [
                'titulo' => 'Reestablecer contraseña',
                'alertas' => $alertas
            ]);
        }

        public static function reestablecer(Router $router) {
            $alertas = [];
            $token = s($_GET['token']);
            $token_valido = true;

            if (!$token) header('Location: /');

            // Identificar al usuario con el token correspondiente.
            $usuario = Usuario::where('token', $token);

            if (empty($usuario)) {
                Usuario::setAlerta('error', '¡Token no válido!');
                $token_valido = false;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Añadir la nueva contraseña.
                $usuario->sincronizar($_POST);

                // Validar la nueva contraseña.
                $alertas = $usuario->validarContrasena();

                if (empty($alertas)) {
                    // Hashear la nueva contraseña.
                    $usuario->hashContrasena();
                    unset($usuario->contrasena2);

                    // Eliminar el Token.
                    $usuario->token = null;

                    // Guardar el usuario en la BD.
                    $resultado = $usuario->guardar();

                    // Redireccionar.
                    if ($resultado) {
                        header('Location: /login');
                    }
                }
            }

            $alertas = Usuario::getAlertas();

            $router->render('auth/reestablecer', [
                'titulo' => 'Reestablecer contraseña',
                'alertas' => $alertas,
                'token_valido' => $token_valido
            ]);
        }

        public static function mensaje(Router $router) {
            $router->render('auth/mensaje', [
                'titulo' => 'Cuenta creada exitosamente'
            ]);
        }

        public static function confirmar_cuenta(Router $router) {
            $alertas = [];
            $token = s($_GET['token']);

            if (!$token) header('Location: /');

            // Encontrar al usuario con el token.
            $usuario = Usuario::where('token', $token);

            if (empty($usuario)) {
                // Cuando no se encontró un usuario con ese token.
                Usuario::setAlerta('error', '¡Token no válido, la cuenta no se confirmó!');
            } else {
                // Confirmar la cuenta.
                $usuario->confirmado = 1;
                $usuario->token = '';
                unset($usuario->contrasena2);
                
                // Guardar en la BD.
                $usuario->guardar();

                Usuario::setAlerta('exito', '¡Cuenta confirmada correctamente!');
            }

            $router->render('auth/confirmar', [
                'titulo' => 'Confirme su cuenta DevWebcamp',
                'alertas' => Usuario::getAlertas()
            ]);
        }
    }