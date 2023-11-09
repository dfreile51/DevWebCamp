<?php

namespace Controllers;

use MVC\Router;

class RegalosController
{
    public static function index(Router $router)
    {
        isAuth();

        $router->render('admin/regalos/index', [
            "titulo" => "Regalos"
        ]);
    }
}
