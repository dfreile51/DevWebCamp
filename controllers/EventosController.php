<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Categoria;
use Model\EventoAll;

class EventosController
{
    public static function index(Router $router)
    {
        if (!isAdmin()) {
            header("Location: /login");
        }

        $alertas = [];
        $mensaje = $_GET["mensaje"] ?? null;
        if ($mensaje) {
            $datos = mensajeAlerta($mensaje, "evento");
            Evento::setAlerta($datos["tipo"], $datos["mensaje"]);
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header("Location: /admin/eventos?page=1");
        }

        $por_pagina = 10;
        $total = Evento::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);

        $query = "SELECT eventos.id, eventos.nombre, eventos.descripcion, categorias.nombre as nombreCategoria, dias.nombre as nombreDia, horas.hora, CONCAT(ponentes.nombre, ' ', ponentes.apellido) as ponente";
        $query .= " FROM eventos";
        $query .= " INNER JOIN categorias ON eventos.categoria_id = categorias.id";
        $query .= " INNER JOIN dias ON eventos.dia_id = dias.id";
        $query .= " INNER JOIN horas ON eventos.hora_id = horas.id";
        $query .= " INNER JOIN ponentes ON eventos.ponente_id = ponentes.id";
        $query .= " ORDER BY eventos.id DESC LIMIT {$por_pagina} OFFSET {$paginacion->offset()}";

        $eventos = EventoAll::SQL($query);

        // debuguear($eventos);

        // $eventos = Evento::paginar($por_pagina, $paginacion->offset());

        // foreach($eventos as $evento) {
        //     $evento->categoria = Categoria::find($evento->categoria_id);
        // }

        $alertas = Evento::getAlertas();

        $router->render('admin/eventos/index', [
            "titulo" => "Conferencias y Workshops",
            "alertas" => $alertas,
            "eventos" => $eventos,
            "paginacion" => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router)
    {
        if (!isAdmin()) {
            header("Location: /login");
        }

        $alertas = [];

        $categorias = Categoria::all("ASC");
        $dias = Dia::all("ASC");
        $horas = Hora::all("ASC");

        $evento = new Evento();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isAdmin()) {
                header("Location: /login");
            }

            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if (empty($alertas)) {
                $resultado = $evento->guardar();

                if ($resultado) {
                    header("Location: /admin/eventos?page=1&mensaje=1");
                }
            }
        }

        $router->render('admin/eventos/crear', [
            "titulo" => "Registrar Evento",
            "alertas" => $alertas,
            "categorias" => $categorias,
            "dias" => $dias,
            "horas" => $horas,
            "evento" => $evento
        ]);
    }

    public static function editar(Router $router)
    {
        if (!isAdmin()) {
            header("Location: /login");
        }

        $alertas = [];

        $id = $_GET["id"];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header("Location: /admin/eventos");
        }

        $categorias = Categoria::all("ASC");
        $dias = Dia::all("ASC");
        $horas = Hora::all("ASC");

        $evento = Evento::find($id);
        if (!$evento) {
            header("Location: /admin/eventos");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isAdmin()) {
                header("Location: /login");
            }

            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if (empty($alertas)) {
                $resultado = $evento->guardar();

                if ($resultado) {
                    header("Location: /admin/eventos?page=1&mensaje=2");
                }
            }
        }

        $router->render('admin/eventos/editar', [
            "titulo" => "Editar Evento",
            "alertas" => $alertas,
            "categorias" => $categorias,
            "dias" => $dias,
            "horas" => $horas,
            "evento" => $evento
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isAdmin()) {
                header("Location: /login");
            }

            $id = $_POST["id"];
            $evento = Evento::find($id);

            if (!isset($evento)) {
                header("Location: /admin/ponentes");
            }

            $resultado = $evento->eliminar();

            if ($resultado) {
                header("Location: /admin/eventos?page=1&mensaje=3");
            }
        }
    }
}
