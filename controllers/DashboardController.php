<?php

namespace Controllers;

use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        isAuth();

        $router->render('admin/dashboard/index', [
            "titulo" => "Panel de Administración"
        ]);
    }
}
