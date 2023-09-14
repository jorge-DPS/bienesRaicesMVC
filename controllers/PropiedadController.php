<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        // Muestra mensaje cuando se creo el anuncio correctamente, trae en la url, el mensaje
        $resultado = $_GET['resultado'] ?? null; // -> si no existe le asiga un valo null; es como el isset()


        $router->render('/propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]); // -> puedo pasar una vista con las hubicaciones
    }

    public static function crear(Router $router)
    {
        $propiedad = new Propiedad;

        $vendedores = Vendedor::all();

        /* Begin::mensaje de errores */
        $errores = Propiedad::getErrores();
        /* End::mensaje de errores */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $propiedad = new Propiedad($_POST['propiedad']); // -> aqui esta la inforamcion del formulario si lo envia incompleto; aun tiene la infomracion

            // debuguear($_FILES['propiedad']['name']);

            /** SUBIDA DE ARCHIVOS */
            $imagen = $_FILES['propiedad']['name'];
            // Genera un nombre único para la imagen
            $extencion = explode('.', $imagen['imagen']); //-> aqui dividimos la cadena por cada punto encontrado; en este caso para la extencion jpg
            $nombreImagen = md5(uniqid(rand(), true)) . '.' . $extencion[count($extencion) - 1]; //-> aqui concatenamos la extencion 

            //setear Iamgen
            //Realiza un resize a la imagen con intervention 

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }


            // Validar
            $errores = $propiedad->validar();

            if (empty($errores)) { //-> si $errores esta vacio entonces inserta los datos
                //CREAR CARPETA
                if (!is_dir(CARPETA_IMAGENES)) { // -> verificamos la carpeta de imagenes
                    mkdir(CARPETA_IMAGENES); //-> crea la carpeta
                }

                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                $propiedad->guardar();



                // mensaje de resultado

                /* End::insertar en la base de datos */
            }
        }
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        /* ejecutar el código después de que el usuario envia el formulario */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //-> aqui verificamos desde la superglobal del server si es POST

            // debuguear($_POST['propiedad']); -> para ver los datos de la variables POST
            // Asignar los atributos
            $array = $_POST['propiedad'];
            $propiedad->sincronizar($array);


            // Validaciopn subida de archivps
            $errores = $propiedad->validar();

            /** SUBIDA DE ARCHIVOS */
            $imagen = $_FILES['propiedad']['name'];
            // Genera un nombre único para la imagen
            $extencion = explode('.', $imagen['imagen']); //-> aqui dividimos la cadena por cada punto encontrado; en este caso para la extencion jpg
            $nombreImagen = md5(uniqid(rand(), true)) . '.' . $extencion[count($extencion) - 1]; //-> aqui concatenamos la extencion 

            //setear Iamgen
            //Realiza un resize a la imagen con intervention 

            // debuguear($_FILES);
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }


            if (empty($errores)) { //-> si $errores esta vacio entonces inserta los datos

                // Almacenar la imagen
                // if ($_FILES['propiedad']['tmp_name']['imagen']) {
                // }

                /* Begin::insertar en la base de datos */
                $propiedad->guardar();
                /* End::insertar en la base de datos */
            }
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    // Elminiar propiedad
                    $propiedad->eliminar();
                }
            }
        }
    }
}
