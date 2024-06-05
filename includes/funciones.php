<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
// define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
//Como ahora tenemos una carpeta public, la ubicacion cambia
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate($nombre, bool $inicio = false){
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado(){
    session_start();
    if(!$_SESSION['login']){
        header('Location: /');
    }
}

function debuggear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;

}

//Escapa / Sanitiza el HTML del formulario
function s($html){
    $s=htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido (esto es en la parte de admin, cuando eliminamos tenemos un input hidden, y si una persona que sepa
//puede editar sus atributos y cambiar su value, para esto nos sirve este codigo)
function validarTipoContenido($tipo){
    $tipos=['vendedor', 'propiedad'];
    //Nota: lo que hace in_array es buscar un valor dentro de un arreglo, el primer parametro es lo que vamos a buscar
    //el segundo parametro es en donde/cual arreglo
    return in_array($tipo, $tipos);
}

//Muestra los mensajes dependiendo del resultado que sea, ej 1,2 o 3, esto para ahorranos lo que ya teniamos y hacerlo dinamico
function mostrarNotificacion($codigo){
    $mensaje = '';

    switch($codigo){
        case(1):
            $mensaje = 'Creado Correctamente';
            break;
        case(2):
            $mensaje = 'Actualizado Correctamente';
            break;
        case(3):
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
    }
    return $mensaje;

}

function validarORedireccionar(string $url){
    $id = $_GET['id'];
    //Validando que ese id sea un int y no un string, ya que alguien puede poner en la url un "hola" por ejemplo
    //modificando la misma variable $id
    $id= filter_var($id, FILTER_VALIDATE_INT);
    //Si no es un int valido redireccionalo a /admin que es el argumento que tenemos
    if(!$id){
        header("Location: $url");
    }

    return $id;
}
