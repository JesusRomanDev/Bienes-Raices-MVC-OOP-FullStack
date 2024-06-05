<?php

namespace Model;

class Propiedad extends ActiveRecord{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        //El nullish coalescing
        //Este retorna el lado derecho si el lado izquierdo es null o undefined
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    //Validando
    public function validar(){
        // debuggear(self::$variableM);
        if(!$this->titulo){
            //Agregando elemento al final de un arreglo, es una manera curiosa, pero ni pedo
            //En JS para agregar se hace con push(final) o unshift(inicio), o tambien en este caso con una sintaxis similar 
            //seria errores[''] = 'Algo';
            //Pero en php pura jalada, es asi como esta abajo
            self::$errores[] = 'Debes añadir un titulo';
        }

        if(!$this->precio){
            self::$errores[] = 'Debe tener un precio';
        }

        if( strlen($this->descripcion) < 50){
            self::$errores[] = 'Debe tener una descripcion y debe ser mayor a 50 caracteres';
        }

        if(!$this->habitaciones){
            self::$errores[] = 'El numero de habitaciones es obligatorio';
        }

        if(!$this->wc){
            self::$errores[] = 'El numero de baños es obligatorio';
        }

        if(!$this->estacionamiento){
            self::$errores[] = 'El numero de lugares de estacionamientos es obligatorio';
        }

        if(!$this->vendedorId){
            self::$errores[] = 'Elige un vendedor';
        }

        //Validando que tenga una imagen o que no haya un error
        if(!$this->imagen){
            self::$errores[] = 'La imagen es obligatoria';
        }

        //Este codigo de abajo ya no es necesario porque le estamos aplicando un resize
        // //Validando tamaño de imagen subida(1MB maximo)
        // $medida = 1000000;
        // if($this->imagen['size'] > $medida){
        //     $errores[] = 'La imagen es muy pesada, subir algo menor a 700kb';
        // }
        return self::$errores;

    }
    
}