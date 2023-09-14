<?php

function conectarDB(): mysqli
{
    date_default_timezone_set('America/La_Paz');
    $db = new mysqli('localhost', 'root', '', 'bienesraices_crud');

    if (!$db) {
        echo "Error no se pudo conectar";
        exit; //-< detienen la coneccion y  no se ejecuta todo el codigo
    }

    return $db;
}
