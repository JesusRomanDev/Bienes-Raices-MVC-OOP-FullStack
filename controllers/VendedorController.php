<?php

namespace Controllers;

use Model\Vendedor;
use MVC\Router;

class VendedorController{
    public static function crear(Router $router){
        $vendedor = new Vendedor();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $vendedor = new Vendedor($_POST);

            $errores = $vendedor->validar();

            if(empty($errores)){
                $resultado = $vendedor->guardar();
                if($resultado){
                    header('Location: /admin?resultado=1');
                }
            }

        }
        
        $erroresAntes = Vendedor::getErrores();
        $router->render('vendedores/crear', [
            "vendedor" => $vendedor,
            'erroresAntes' => $erroresAntes
        ]);
    }

    public static function actualizar(Router $router){
        $id = $_GET['id'];
        $id = validarORedireccionar('/admin');
        $vendedor = Vendedor::find($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $vendedor->sincronizar($args);

            $errores = $vendedor->validar();

            if(empty($errores)){
                $resultado = $vendedor->guardar();
                if($resultado){
                    header('Location: /admin?resultado=2');
                }
            }

        }
        
        $erroresAntes = Vendedor::getErrores();

        $router->render('vendedores/actualizar', [
            "vendedor" => $vendedor,
            'erroresAntes' => $erroresAntes
        ]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // debuggear($_POST);
            $id = $_POST['id'];
            $id= filter_var($id, FILTER_VALIDATE_INT);
            if($id){
                //Usando la funcion para validar que el tipo sea vendedor o propiedad
                if(validarTipoContenido($_POST['tipo'])){
                    $vendedor = Vendedor::find($id);
                    $resultado = $vendedor->eliminar();
                }
                //Eliminando el archivo de imagen DE LA CARPETA IMAGENES
                // $query = "SELECT imagen FROM propiedades where id = $id";
                // $resultado = mysqli_query($db, $query);
                // $propiedad = mysqli_fetch_assoc($resultado);
                // unlink('../imagenes/' . $propiedad['imagen'] . '.jpg');
    
                // $resultado = mysqli_query($db, $query);
                if($resultado){
                    header('location: /admin?resultado=3');
                }
            }
        }
    }
}