<?php

namespace MVC;

class Router
{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn)
    {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->rutasPOST[$url] = $fn;
    }
    public function comprobarRutas()
    {
        $urlactual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlactual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlactual] ?? null;
        }

        if ($fn != null) {
            // La url existe y hay una funcion asociada}
            call_user_func($fn, $this); //->call_user_func() sirve para llamar a fuunciones que no se sabe como se llaman
        } else {
            echo "pagian no encontrada";
        }
    }

    // Muestra una vista
    public function render($view, $datos = [])
    {
        // [
        //     'mensaje' => 1,
        //     'propiedades' => [1, 2, 3]
        // ]

        foreach ($datos as $key => $value) {
            $$key = $value;
        }
        ob_start(); // -> estamos diciendole al framework que empiese a guardar en memoria desde aqui por un momento...
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // -> limpiamos y lo guardamos en contenido para injectarlo a al vista que esta abajo
        include_once __DIR__ . '/views/layout.php'; //-> y lo pasamos el $contenido a esata vista
    }
}
