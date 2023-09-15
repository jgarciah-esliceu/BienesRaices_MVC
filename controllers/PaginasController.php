<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::get(3);
        $inicio = true;
        
        $router->render('/paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        $router->render('/paginas/nosotros', []);
    }

    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();
        
        $router->render('/paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {

        $id = validarORedireccionar('/propiedades');

        //Buscar la propiedad por su id
        $propiedad = Propiedad::find($id);
        
        $router->render('/paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router) {
        
        $router->render('/paginas/blog');
    }

    public static function entrada(Router $router) {
        $router->render('/paginas/entrada');
    }

    public static function contacto(Router $router) {

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];
            
            debuguear($respuestas);

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '038ba61df7c630';
            $mail->Password = '19c493a30f6f14';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // definir el contenido
            $contenido = '<html>' ;
            $contenido .= '<h1> Tienes un nuevo mensaje </h1> '; 
            $contenido .= '<p> <b> Nombre: </b>' . $respuestas['nombre'] . ' </p> '; 
            $contenido .= '<p> <b> Vende o Compra: </b>' . $respuestas['tipo'] . ' </p> '; 
            $contenido .= '<p> <b> Precio o presupuesto: </b>' . $respuestas['precio'] . '€ </p> '; 
            $contenido .= '<p> <b> Mensaje: </b>' . $respuestas['mensaje'] . ' </p> '; 

            // Enviar de forma condicional algunos campos de email o telefono
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<br>';
                $contenido .= '<p> <b> Eligió ser contactado por teléfono:  </b> </p>';
                $contenido .= '<p> <b> Teléfono: </b>' . $respuestas['telefono'] . ' </p> ';
                $contenido .= '<p> <b> Fecha de contacto: </b>' . $respuestas['fecha'] . ' </p> '; 
            $contenido .= '<p> <b> Hora de contacto: </b>' . $respuestas['hora'] . ' </p> '; 
            } else {
                // es un email
                $contenido .= '<br>';
                $contenido .= '<p> <b> Eligió ser contactado por email:  </b> </p>';
                $contenido .= '<p> <b> Email: </b>' . $respuestas['email'] . ' </p> ';
            }            
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es text alternativo sin HTML';

            // Enviar el mensaje
            if($mail->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
            
        }
        
        $router->render('/paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}