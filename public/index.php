<?php 
    require_once __DIR__ . '/../includes/app.php';

	use MVC\Router;
    use Controllers\AuthController;
    use Controllers\DashboardController;
    use Controllers\PonenteController;
    use Controllers\EventoController;
    use Controllers\APIEvento;
    use Controllers\APIPonente;
    use Controllers\APIRegalo;
    use Controllers\RegistradoController;
    use Controllers\RegaloController;
    use Controllers\RegistroController;
    use Controllers\PaginaController;

    $router = new Router();

    // Login
    $router->get('/login', [AuthController::class, 'login']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/logout', [AuthController::class, 'logout']);

    // Crear Cuenta
    $router->get('/registro', [AuthController::class, 'registro']);
    $router->post('/registro', [AuthController::class, 'registro']);

    // Formulario de olvide mi password
    $router->get('/olvide', [AuthController::class, 'olvide']);
    $router->post('/olvide', [AuthController::class, 'olvide']);

    // Colocar el nuevo password
    $router->get('/reestablecer', [AuthController::class, 'reestablecer']);
    $router->post('/reestablecer', [AuthController::class, 'reestablecer']);

    // Confirmación de Cuenta
    $router->get('/mensaje', [AuthController::class, 'mensaje']);
    $router->get('/confirmar_cuenta', [AuthController::class, 'confirmar_cuenta']);

    // Área de administración.
    $router->get('/admin/dashboard', [DashboardController::class, 'index']);

    $router->get('/admin/ponentes', [PonenteController::class, 'index']);
    $router->get('/admin/ponentes/crear', [PonenteController::class, 'crear']);
    $router->post('/admin/ponentes/crear', [PonenteController::class, 'crear']);
    $router->get('/admin/ponentes/editar', [PonenteController::class, 'editar']);
    $router->post('/admin/ponentes/editar', [PonenteController::class, 'editar']);
    $router->post('/admin/ponentes/eliminar', [PonenteController::class, 'eliminar']);

    $router->get('/admin/eventos', [EventoController::class, 'index']);
    $router->get('/admin/eventos/crear', [EventoController::class, 'crear']);
    $router->post('/admin/eventos/crear', [EventoController::class, 'crear']);
    $router->get('/admin/eventos/editar', [EventoController::class, 'editar']);
    $router->post('/admin/eventos/editar', [EventoController::class, 'editar']);
    $router->post('/admin/eventos/eliminar', [EventoController::class, 'eliminar']);

    $router->get('/api/eventos_horario', [APIEvento::class, 'index']);
    $router->get('/api/ponentes', [APIPonente::class, 'index']);
    $router->get('/api/ponente', [APIPonente::class, 'ponente']);
    $router->get('/api/regalos', [APIRegalo::class, 'index']);

    $router->get('/admin/registrados', [RegistradoController::class, 'index']);

    $router->get('/admin/regalos', [RegaloController::class, 'index']);

    // Registro de usuarios, boleto gratuito.
    $router->get('/finalizar_registro', [RegistroController::class, 'crear']);
    $router->post('/finalizar_registro/gratuito', [RegistroController::class, 'gratuito']);
    $router->post('/finalizar_registro/pagar', [RegistroController::class, 'pagar']);
    $router->get('/finalizar_registro/conferencias', [RegistroController::class, 'conferencias']);
    $router->post('/finalizar_registro/conferencias', [RegistroController::class, 'conferencias']);

    // Registro de usuarios, boleto virtual.
    $router->get('/boleto', [RegistroController::class, 'boleto']);

    // Área pública.
    $router->get('/', [PaginaController::class, 'index']);
    $router->get('/devwebcamp', [PaginaController::class, 'devwebcamp']);
    $router->get('/paquetes', [PaginaController::class, 'paquetes']);
    $router->get('/conferencias_workshops', [PaginaController::class, 'conferencias']);

    $router->get('/404', [PaginaController::class, 'error']);

    $router->comprobarRutas();