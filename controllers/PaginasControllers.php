<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasControllers
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros',  []);
    }
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }

    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('propiedades');
        // buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad,
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog', []);
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada', []);
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            // Crear n ainstancia de php mailer
            $mail = new PHPMailer();
            // Configurar SMPT
            $mail->isSMTP();
            $mail->Host = "sandbox.smtp.mailtrap.io";
            $mail->SMTPAuth = true;
            $mail->Username = "da49f4e0f1fafe";
            $mail->Password = "3e139ba9b76275";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            // Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'tienes un nuevo mensaje';

            // habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';


            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p> teines un nuevo mensaje </p> ';
            $contenido .= '<p>Nombre:' . $respuestas['nombre'] . ' </p> ';


            // Enviar de forma condicional algunos de email a telefono

            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligio ser contactado por Teléfono</p> ';
                $contenido .= '<p>Telefono:' . $respuestas['telefono'] . ' </p> ';
                $contenido .= '<p>Fecha;' . $respuestas['fecha'] . ' </p> ';
                $contenido .= '<p>Hora:' . $respuestas['hora'] . ' </p> ';
            } else {
                // es email, entonces agragmos el campo de email
                $contenido .= '<p>Eligio ser contactado por email</p> ';
                $contenido .= '<p>Email:' . $respuestas['email'] . ' </p> ';
            }

            $contenido .= '<p>Mensaje:' . $respuestas['mensaje'] . ' </p> ';
            $contenido .= '<p>Compora o Venta:' . $respuestas['tipo'] . ' </p> ';
            $contenido .= '<p>Precio o Presupuesto:' . $respuestas['precio'] . ' </p> ';
            $contenido .= '<p>Prefiere se contactado por:' . $respuestas['contacto'] . ' </p> ';

            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'esto es texto alternativo sin html';

            // Enviar eñ email
            // debuguear($mail->send());
            if ($mail->send()) {
                $mensaje = 'Mensaje envaido correctamente';
            } else {
                $mensaje = "El mensaje no se pudo enviar..." . $mail->ErrorInfo;
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
