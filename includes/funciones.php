<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function mensajeAlerta($tipo, $texto): array
{
    switch ($tipo) {
        case "1":
            $datos = [
                "mensaje" => "El " . $texto . " ha sido creado correctamente",
                "tipo" => "exito"
            ];
            break;
        case "2":
            $datos = [
                "mensaje" => "El " . $texto . " ha sido actualizado correctamente",
                "tipo" => "exito"
            ];
            break;
        case "3":
            $datos = [
                "mensaje" => "El " . $texto . " ha sido eliminado correctamente",
                "tipo" => "exito"
            ];
            break;
        default:
            $datos = [
                "mensaje" => "Error, acción no encontrada",
                "tipo" => "error"
            ];
            break;
    }

    return $datos;
}

function pagina_actual($path): bool
{
    return str_contains($_SERVER["PATH_INFO"] ?? '/', $path) ? true : false;
}

function checkSession(): void
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

// Comprueba si el usuario a iniciado sesión, si no lo está, lo redirecciona a la página de inicio
function isAuth(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION["nombre"]) && !empty($_SESSION);
}

function isAdmin(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION["admin"]) && !empty($_SESSION["admin"]);
}

function aos_animacion(): void
{
    $efectos = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];

    $efecto = array_rand($efectos, 1);

    echo " data-aos='" . $efectos[$efecto] . "' ";
}
