<?php
namespace Controllers;

use Model\Propiedad;
use Model\Blog;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{
    public static function index(Router $route){
        $propiedades = Propiedad::get(3);
        $route->render('paginas/index', [
            "propiedades" => $propiedades,
            "inicio" => true
        ]);
    }

    public static function nosotros(Router $route){
        $route->render('paginas/nosotros', [
        ]);
    }

    public static function propiedades(Router $route){
        $propiedades = Propiedad::all();
        $route->render('paginas/propiedades', [
            "propiedades" => $propiedades
        ]);
    }

    public static function propiedad(Router $route){
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $route->render('paginas/propiedad', [
            "propiedad" => $propiedad
        ]);
    }

    public static function blog(Router $route){
        $anuncios = Blog::all();
        // debuggear($anuncios);
        $route->render('paginas/blog', [
            "anuncios" => $anuncios
        ]);
    }

    public static function entrada(Router $route){
        $id = validarORedireccionar('/admin');
        $anuncio = Blog::find($id);
        // debuggear($anuncios);
        $route->render('paginas/entrada', [
            "anuncio" => $anuncio
        ]);
    }

    public static function contacto(Router $route){
        $mensaje = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $respuestas = $_POST;
            // debuggear($respuestas);
            //Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            //Configurar SMTP (esto es el protocolo que se usa para el envio de emails)
            $mail->isSMTP(); //vamos a utilizar SMPT para el envio de correos
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $_ENV['EMAIL_PORT'];

            //Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com'); //quien lo va a enviar
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //quien lo va a recibir
            $mail->Subject = 'Tienes un nuevo Mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' .$respuestas['nombre'] . '</p>';
            
            //Enviar de forma condicional algunos campos de email o telefono
            //-----------ESTO NOS SIRVE SI NO FUERA POR CULPA DEL PINCHE GULP, PERO ASI SE HACE-----------
            // if($respuestas['contacto'] === 'telefono'){
            //     $contenido .= '<p>Eligio ser contactado por telefono:</p>';
            //     $contenido .= '<p>Telefono: ' .$respuestas['telefono'] . '</p>';
            // }else{
            //     //Es email, entonces agregamos el campo de email
            //     $contenido .= '<p>Eligio ser contactado por email:</p>';
            //     $contenido .= '<p>Email: ' .$respuestas['email'] . '</p>';

            // }
            $contenido .= '<p>Email: ' .$respuestas['email'] . '</p>';
            $contenido .= '<p>Telefono: ' .$respuestas['telefono'] . '</p>';
            $contenido .= '<p>Mensaje: ' .$respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' .$respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' .$respuestas['precio'] . '</p>';
            $contenido .= '<p>Prefiere ser contactado por: ' .$respuestas['contacto'] . '</p>';
            $contenido .= '<p>Fecha Contacto: ' .$respuestas['fecha'] . '</p>';
            $contenido .= '<p>Hora: ' .$respuestas['hora'] . '</p>';
            $contenido .= '</html>';


            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            //Enviar el email
            if($mail->send()){
                $mensaje =  "Mensaje enviado correctamente";
            }else{
                $mensaje = "mensaje no enviado";
            }
        }
        $route->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}