<?php


// require 'app.php'; //-> aqui tiene las funciones: TEMPLATES_URL, FUNCIONES_URL
// funcion para el header 

define('TEMPLATES_URL', __DIR__ . '/templates'); //-> __DIR__ sirve par que la direccion del archivo sea completo dessde la raiz donde esta ubicado
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER["DOCUMENT_ROOT"] . '/imagenes/');

function incluirTemplates(string $nombreTemplate, bool $inicio = false)
{
    include TEMPLATES_URL . "/$nombreTemplate.php";
}

function estaAutenticado()
{
    session_start();
    if (!$_SESSION['login']) {
        header('Location: /');
    }
}

function debuguear($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';

    exit;
}

// Escapar / Sanitizar el HTML 
function sanitizar($html): string
{
    $s = htmlspecialchars($html);
    return $s;
} // Validar tipo de contenido
function validarContenido($tipo)
{
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}


// Mustra las Mensajes alertas
function mostrarNotificacion($codigo)
{
    $mensaje = '';
    switch ($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Elminado correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function validarORedireccionar(string $url)
{
    /** Begin::Validar la URL por Id valido */
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if (!$id) {
        header("Location: $url");
    }
    // var_dump($id);
    /** End::Validar la URL por Id valido */

    return $id;
}
