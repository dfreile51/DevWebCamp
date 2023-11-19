<?php

namespace Model;

class EventoAll extends ActiveRecord
{
    public static $tabla = "eventos";
    public static $columnasDB = ["id", "nombre", "descripcion", "nombreCategoria", "nombreDia", "hora", "ponente"];

    public $id;
    public $nombre;
    public $descripcion;
    public $nombreCategoria;
    public $nombreDia;
    public $hora;
    public $ponente;
}