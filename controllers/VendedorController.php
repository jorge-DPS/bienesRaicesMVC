<?php

namespace Controllers;

use GuzzleHttp\Psr7\Request;
use MVC\Router;
use Model\Vendedor;

class VendedorController
{
    public static function crear(Router $router)
    {
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validar que no haya campos vacios
            $errores = $vendedor->validar();

            // No hay errores
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor,
        ]);
    }

    public static function actualizar(Router $router)
    {
        // Areglo con mensajes de errores
        $errores = Vendedor::getErrores();

        // O]btener el arreglo del vendedor
        $id = validarORedireccionar('/admin');
        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los valores
            $args = $_POST['vendedor'];

            // Sincronizar objeto en memoria con lo que el usuario  escribió
            $vendedor->sincronizar($args);

            // Validacion
            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }
        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor,
        ]);
    }

    public static function Eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //validar el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                // valida el tipo  a eliminar
                $tipo = $_POST['tipo'];

                if (validarContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
