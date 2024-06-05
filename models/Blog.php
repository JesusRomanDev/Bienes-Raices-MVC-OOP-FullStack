<?php 
namespace Model;

class Blog extends ActiveRecord {
    protected static $tabla = 'articulos';
    protected static $columnasDB = ['id', 'titulo', 'imagen', 'fecha', 'autor', 'descripcion'];

    public $id; 
    public $titulo; 
    public $imagen; 
    public $fecha; 
    public $autor; 
    public $descripcion; 


}