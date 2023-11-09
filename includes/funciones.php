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
    return str_contains($_SERVER["PATH_INFO"], $path) ? true : false;
}

function checkSession(): void
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

// Comprueba si el usuario a iniciado sesión, si no lo está, lo redirecciona a la página de inicio
function isAuth(): void
{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}
