<?php

namespace Model;

class Admin extends ActiveRecord{
    //DB
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar(){
        if(!$this->email){
            self::$errores[] = 'El email es obligatorio';
        }

        if(!$this->password){
            self::$errores[] = 'El password es obligatorio';
        }

        return self::$errores;

    }

    public function existeUsuario(){
        //Revisar si un usuario existe o no
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        //Recordando que este $resultado es lo que hay en LA BASE DE DATOS
        $resultado = self::$db->query($query);
        // debuggear($resultado->num_rows);
        if(!$resultado->num_rows){
            self::$errores[] = 'El Usuario no existe';
            return;
        }
        return $resultado;

    }

    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object(); //<------ esto nos trae el resultado de lo que encuentre en la base de datos
        //el resultado contendra todo de ese objeto... id, email y PASSWORD
        // debuggear($usuario);

        //Ya teniendo el objeto
        $autenticado = password_verify($this->password, $usuario->password); //nos retorna true o false
        // debuggear($autenticado);

        if(!$autenticado){
            self::$errores[] = 'El Password es incorrecto';
            return;
        }
        return $autenticado;
    }

    public function autenticar(){
        session_start();

        //Llenar el arreglo de session
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;
        header('Location: /admin');

    }
}