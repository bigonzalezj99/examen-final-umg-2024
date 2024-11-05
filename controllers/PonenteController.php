<?php
    namespace Controllers;
    
    use Classes\Paginacion;
    use Model\Ponente;
    use Intervention\Image\ImageManagerStatic as Image;
    use MVC\Router;

    class PonenteController {
        public static function index(Router $router) {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $paginaActual = $_GET['page'];
            $paginaActual = filter_var($paginaActual, FILTER_VALIDATE_INT);

            if (!$paginaActual || $paginaActual < 1) header('Location: /admin/ponentes?page=1');

            $registrosPorPagina = 10;
            $totalRegistros = Ponente::total();
            $paginacion = new Paginacion($paginaActual, $registrosPorPagina, $totalRegistros);

            if ($paginacion->totalPaginas() < $paginaActual) header('Location: /admin/ponentes?page=1');

            $ponentes = Ponente::paginar($registrosPorPagina, $paginacion->offset());

            $router->render('admin/ponentes/index',[
                'titulo' => 'Listado de ponentes',
                'ponentes' => $ponentes,
                'paginacion' => $paginacion->paginacion()
            ]);
        }

        public static function crear(Router $router) {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $alertas =[];
            $ponente = new Ponente;

            // Cuando el usuario envía la información del formulario.
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isAdmin()) {
                    header('Location: /login');
                    return;
                }

                // Leer la imagen.
                if (!empty($_FILES['imagen']['tmp_name'])) {
                    $carpetaImagenes = __DIR__ . '/../public/img/speakers';

                    if (!is_dir($carpetaImagenes)) {
                        mkdir($carpetaImagenes, 0755, true);
                    }

                    $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                    $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                    $nombreImagen = md5(uniqid(rand(), true));

                    $_POST['imagen'] = $nombreImagen;
                }
                
                $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

                $ponente->sincronizar($_POST);
                $alertas = $ponente->validar();

                // Guardar el registro.
                if (empty($alertas)) {
                    // Guardar las imágenes.
                    $imagen_png->save($carpetaImagenes . '/' . $nombreImagen . '.png');
                    $imagen_webp->save($carpetaImagenes . '/' . $nombreImagen . '.webp');

                    // Guardar en la Base de Datos.
                    $resultado = $ponente->guardar();

                    if ($resultado) header('Location: /admin/ponentes');
                }
            }

            $router->render('admin/ponentes/crear',[
                'titulo' => 'Registrar ponente',
                'alertas' => $alertas,
                'ponente' => $ponente,
                'redes' => json_decode($ponente->redes)
            ]);
        }

        public static function editar(Router $router) {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $alertas = [];

            // Validar el ID a editar.
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if (!$id) header('Location: /admin/ponentes');

            // Obtener el ponente a editar.
            $ponente = Ponente::find($id);

            if (!$ponente) header('Location: /admin/ponentes');

            $ponente->imagen_actual = $ponente->imagen;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isAdmin()) {
                    header('Location: /login');
                    return;
                }

                if (!empty($_FILES['imagen']['tmp_name'])) {
                    $carpetaImagenes = __DIR__ . '/../public/img/speakers';

                    // Eliminar la imagen previa
                    unlink($carpetaImagenes . '/' . $ponente->imagen_actual . ".png" );
                    unlink($carpetaImagenes . '/' . $ponente->imagen_actual . ".webp" );

                    if (!is_dir($carpetaImagenes)) {
                        mkdir($carpetaImagenes, 0755, true);
                    }

                    $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                    $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                    $nombreImagen = md5(uniqid(rand(), true));

                    $_POST['imagen'] = $nombreImagen;
                } else {
                    $_POST['imagen'] = $ponente->imagen_actual;
                }

                $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

                $ponente->sincronizar($_POST);
                $alertas = $ponente->validar();

                if (empty($alertas)) {
                    // Verificar si hay nueva imagen.
                    if (isset($nombreImagen)) {
                        $imagen_png->save($carpetaImagenes . '/' . $nombreImagen . '.png');
                        $imagen_webp->save($carpetaImagenes . '/' . $nombreImagen . '.webp');
                    }

                    $resultado = $ponente->guardar();

                    if ($resultado) header('Location: /admin/ponentes');
                }
            }

            $router->render('admin/ponentes/editar', [
                'titulo' => 'Actualizar ponente',
                'alertas' => $alertas,
                'ponente' => $ponente,
                'redes' => json_decode($ponente->redes)
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
                $ponente = Ponente::find($id);

                if (!isset($ponente)) header('Location: /admin/ponentes'); 

                if ($ponente->imagen) {
                    // Eliminar la imagen previa
                    $carpetaImagenes = __DIR__ . '/../public/img/speakers';

                    unlink($carpetaImagenes . '/' . $ponente->imagen . ".png" );
                    unlink($carpetaImagenes . '/' . $ponente->imagen . ".webp" );
                }

                $resultado = $ponente->eliminar();

                if ($resultado) header('Location: /admin/ponentes');
            }
        }
    }