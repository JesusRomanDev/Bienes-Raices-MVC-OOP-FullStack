<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController{
    public static function login(Router $router){
        $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if(empty($errores)){
                //Verificar si el usuario existe
                $resultado = $auth->existeUsuario();
                //------------------------NOTAS SUPER IMPORTANTES--------------------------------------------------
                //Si nuestro num_rows tiene un valor es que es correcto
                // debuggear($resultado->num_rows);
                //Entonces si tenemos  un valor en nums_rows podemos TRAERNOS ESE VALOR con FETCH_OBJECT
                // debuggear($resultado->fetch_object());

                if(!$resultado){
                    //Mostrando los mensajes de error en caso de que no exista el usuario
                    $errores = Admin::getErrores();
                }else{
                    //Si existe el usuario
                    //Verificar el password

                    //Aqui le pasamos ese $resultado para despues dentro de la funcion comprobarPassword usar el fetch_object
                    //que dijimos arriba
                    $autenticado = $auth->comprobarPassword($resultado);
                    // debuggear($autenticado);
                    if($autenticado){
                        //Autenticar el usuario
                        $auth->autenticar();
                    }else{
                        //Password incorrecto
                        $errores = Admin::getErrores();
                    }

                }
            }
        }
        $router->render('auth/login', [
            'errores'=> $errores
        ]);
    }

    public static function logout(){
        //Para deslogearse primero se vuelve a comenzar la session, despues vaciamos $_SESSION y lo redireccionamos
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
}