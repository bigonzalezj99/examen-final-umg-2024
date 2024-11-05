<?php
    namespace Controllers;

    use MVC\Router;

    class RegaloController {
        public static function index(Router $router) {
            if (!isAdmin()) {
                header('Location: /login');
                return;
            }

            $router->render('admin/regalos/index',[
                'titulo' => 'Listado de regalos'
            ]);
        }
    }