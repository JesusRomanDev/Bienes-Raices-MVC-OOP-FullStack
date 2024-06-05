<?php 
namespace Model;
use Model\Blog;

class ActiveRecord{
    //Base de Datos
    protected static $db;
    // protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
    //EL CODIGO DE ARRIBA FUE REEMPLAZADO POR EL DE ABAJO PARA HACERLO DINAMICO YA QUE AHORA TENEMOS NUESTRA SEGUNDA CLASE DE VENDEDOR
    //Lo dejamos vacio asi como $tabla pero en este caso es un array vacio
    protected static $columnasDB = [];
    //Agregando esta propiedad para usarlo en la clase diferente a Propiedades que es Vendedores
    protected static $tabla = '';
    //Errores
    protected static $errores = []; 

    protected static $variableM = 'O';


    //Vieja manera antes de PHP8
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
    //ESTOS DE AQUI ARRIBA SE eliminan, YA QUE TENEMOS AHORA 2 CLASES

    //Este CONSTRUCT COMO AHORA SE VA A HACER POR CASA CLASE, SE VA A ELIMINAR
    // public function __construct($args = [])
    // {
    //     //El nullish coalescing
    //     //Este retorna el lado derecho si el lado izquierdo es null o undefined
    //     $this->id = $args['id'] ?? '';
    //     $this->titulo = $args['titulo'] ?? '';
    //     $this->precio = $args['precio'] ?? '';
    //     $this->imagen = $args['imagen'] ?? '';
    //     $this->descripcion = $args['descripcion'] ?? '';
    //     $this->habitaciones = $args['habitaciones'] ?? '';
    //     $this->wc = $args['wc'] ?? '';
    //     $this->estacionamiento = $args['estacionamiento'] ?? '';
    //     $this->creado = date('Y/m/d');
    //     $this->vendedorId = $args['vendedorId'] ?? 1;
    // }

    public function guardar(){
        if(!empty($this->id)){
            //Actualizando un registro
            $resultado = $this->actualizar();
            return $resultado;
        }else{
            //Creando un registro
            $resultado = $this->crear();
            return $resultado;
        }
    }

    public function crear(){
        //Sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();
        // debuggear($atributos);
        //Ahora, vamos a usar join para poder obtener solo los values de nuestro array en un STRING
        //Join como primer parametro es el separador, algo asi como el splice de JS
        //solo que aqui vamos a agregar esa COMA Y ESPACIO, entre cada una de nuestras keys
        $columnas = join(', ', array_keys($atributos));
        //Tambien aplicaremos para el INSERT INTO propiedades()
        $filas = join("', '", array_values($atributos));
        // debuggear($columnas);
        // debuggear($columnas);
        //Insertando en la base de datos
        //Nota: la imagen en los values vendria siendo solo el texto, osease la variable $nombreImagen
        // $query = "INSERT INTO propiedades ($columnas) VALUES ('$filas')"; <- ESTE FUE REEMPLAZADO POR EL DE ABAJO 
        //GRACIAS A QUE AHORA TENEMOS 2 CLASES, LA DE PROPIEDAD Y VENDEDOR, ya que este solo aplicaba cuando teniamos la clase
        //de Propiedad y estabamos insertando en propiedades, pero para hacerlo dinamico tenemos este codigo de aqui abajo
        //PARA MAS INFO IRNOS A EL METODO all(), ahi tenemos mas apuntes
        $query = "INSERT INTO " . static::$tabla . " ($columnas) 
        VALUES ('$filas')";
        // debuggear($query);
        $resultado = self::$db->query($query);
        // debuggear($resultado);
        return $resultado;
        // debuggear($resultado);
    }
    //NOTA IMPORTANTISIMA: TODO LO QUE SEA COMO PUBLIC HAREMOS REFERENCIA A EL CON $THIS, TODO LO STATIC CON SELF

    //Actualizando
    public function actualizar(){
        //Sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();
        //Ahora con la variable de abajo lo que haremos sera usarla en el $query pero antes tenemos que setearla para que quede
        //algo similar a esto en el value
        // titulo= '$titulo', precio='$precio', imagen= '$nombreImagen', descripcion='$descripcion', habitaciones= $habitaciones, wc=$wc, estacionamiento=$estacionamiento, vendedorId=$vendedorId where id = $id";
        $valores = [];
        foreach($atributos as $key=> $value){
            $valores[] = "$key = '$value'";
        }
        $valoresJoin =join(', ', $valores);
        $query = "UPDATE " . static::$tabla . " SET $valoresJoin where id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        // debuggear($query);
        $resultado = self::$db->query($query);
        return $resultado;
        // if($resultado){
        //     //Redireccionando al usuario
        //     //Nota: usar el header para redireccionar siempre y cuando antes del codigo no se encuentre codigo HTML
        //     //despues del admin, podemos enviar en la url los parametros, algo asi como useParams() de react y js
        //     //Nota: este "=2" es un string, hay que cambiar su tipo de dato a entero o al hacer una comparacion para mostrar
        //     //un resultado solo unar == en vez de ===
        //     //Nota de la nota: como en crear le dijimos que resultado=1 aqui entonces debemos cambiarlo a resultado=2
        //     //Para que en el if del index.php nos diga si se "creo" o se "actualizo"
        //     header('Location: /admin?resultado=2');
        //     // echo "registro";
        // }

    }


    //Definir la conexion a la DB
    public static function setDB($database){
        self::$db = $database;
        //Tambien se puede usar
        //Propiedad::
    }

    //Eliminar un registro
    public function eliminar(){
        //Eliminando la propiedad
        $query = "DELETE FROM " . static::$tabla . " where id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        // debuggear($query);
        $resultado = self::$db->query($query);
        if($resultado){
            $this->borrarImagen();
        }
        return $resultado;
    }

    //Este se va a encargar de iterar sobre columnasDB, para asignar la propiedad y seguir maneteniendo como value las variables
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            //Nota: aqui abajo vamos a ignorar id ya que aun no existe
            if($columna === 'id') continue;
            $atributos[$columna] = $this-> $columna;
            //$atributos['titulo'] = (este objeto instanciado) $this -> (la variable $id, $titulo) $columna
        }
        //Todos estos atributos es como el req method $_POST los deja, en un array asociativo
        return $atributos;
    }

    //Este va a sanitizar
    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        // debuggear($sanitizado);
        return $sanitizado;
    }

    //Subida de archivos para la imagen
    public function setImagen($imagen){
        //SI HAY UN ID SIGNIFICA QUE ESTAMOS EDITANDO/ACTUALIZANDO, SI NO HAY ID ENTONCES ESTAMOS CREANDO
        //Este codigo de abajo solo nos sirve para cuando actualizamos una imagen, sirve para ver si hay imagen previa y reemplazarlo
        //Si hay un id (esto significa que entonces esto que se esta evaluando ya fue creado)
        if(isset($this->id)){
            //Comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen . '.jpg');
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen . '.jpg');
            }
        }
        if($imagen){
            // debuggear('si hay imagen');
            $this->imagen = $imagen;
        }
        // else{
        //     debuggear('no hay imagen');
        // }
    }

    //Borrar la Imagen
    public function borrarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen . '.jpg');
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen . '.jpg');
        }
    }

    //Validacion
    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        //------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------
        //NOTA SUPER IMPORTANTE: HAY QUE LLEVARNOS TOOOOOODOOOOOO ESTO DE ABAJO HACIA NUESTRA CLASE CORRESPONDIENTE
        //------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------

        // //Validando
        // if(!$this->titulo){
        //     //Agregando elemento al final de un arreglo, es una manera curiosa, pero ni pedo
        //     //En JS para agregar se hace con push(final) o unshift(inicio), o tambien en este caso con una sintaxis similar 
        //     //seria errores[''] = 'Algo';
        //     //Pero en php pura jalada, es asi como esta abajo
        //     self::$errores[] = 'Debes añadir un titulo';
        // }

        // if(!$this->precio){
        //     self::$errores[] = 'Debe tener un precio';
        // }

        // if( strlen($this->descripcion) < 50){
        //     self::$errores[] = 'Debe tener una descripcion y debe ser mayor a 50 caracteres';
        // }

        // if(!$this->habitaciones){
        //     self::$errores[] = 'El numero de habitaciones es obligatorio';
        // }

        // if(!$this->wc){
        //     self::$errores[] = 'El numero de baños es obligatorio';
        // }

        // if(!$this->estacionamiento){
        //     self::$errores[] = 'El numero de lugares de estacionamientos es obligatorio';
        // }

        // if(!$this->vendedorId){
        //     self::$errores[] = 'Elige un vendedor';
        // }

        // //Validando que tenga una imagen o que no haya un error
        // if(!$this->imagen){
        //     self::$errores[] = 'La imagen es obligatoria';
        // }

        // //Este codigo de abajo ya no es necesario porque le estamos aplicando un resize
        // // //Validando tamaño de imagen subida(1MB maximo)
        // // $medida = 1000000;
        // // if($this->imagen['size'] > $medida){
        // //     $errores[] = 'La imagen es muy pesada, subir algo menor a 700kb';
        // // }
        //
        //Static ira a la clase hijo o respectivamente la clase que lo llama, NO ACTIVE RECORD CON EL SELF
        // debuggear("echoActive");
        self::$variableM = 'Nuev'; //<----------este codigo de aca es para que cada que valide 
        return self::$variableM;
    }

    //OBTIENE DETERMINADO NUMERO DE REGISTROS(ESTE ES PARA EL LIMITE EN LA PAGINA PRINCIPAL)
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        // debuggear($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Lista todas las propiedades
    public static function all(){
        // $query = "SELECT * FROM propiedades";
        //El codigo de arriba para hacerlo dinamico con la clase Propiedad y Vendedor hay que hacerlo de la sig manera
        //El modificador de acceso STATIC, static va a HEREDAR ESTE METODO (public static function all() ) y va a bucar el
        //atributo $tabla DE LA CUAL SE LE ESTE HEREDANDO, propiedades o vendedores en su CLASE respectiva
            $query = "SELECT * FROM " . static::$tabla;
        // debuggear($query);
        // $resultado = self::$db->query($query);
        //Este resultado de arriba nos los podriamos traer con un fetch_assoc PERO RECORDEMOS QUE ESTAMOS TRABAJANDO CON OBJETOS
        //porque este fetch assoc nos traera un arreglo asociativo
        // debuggear($resultado);
        //Y RECORDANDO QUE ESTAMOS TRABAJANDO CON ACTIVE RECORD, ESO SIGNIFICA QUE HAY QUE TENER OBJETOS AL IGUAL QUE LO QUE HAY 
        //EN MEMORIA
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Lista SOLO 1 PROPIEDAD por su id
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " where id=$id";
        //Ahora tenemos que recordar, que estamos bajo Active Record, entonces todo lo tenemos que manejar como objeto evitando los arrays 
        //por suerte ya tenemos una funcion que hace eso
        $resultado = self::consultarSQL($query);
        // debuggear($resultado);
        //Retornando el primer elemento/primer posicion de nuestro array de objetos
        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        //Consultar la base de datos
        // debuggear($query);
        $resultado = self::$db->query($query);
        // debuggear($resultado->num_rows);
        //El query a la DB nos da como resultado un mysqli object
        //For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries, mysqli_query() will return a mysqli_result object. For other successful queries mysqli_query() will return TRUE. Returns FALSE on failure.
        // debuggear($resultado);
        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            //Usando un metodo de objeto con '->' para que el resultado llame a fetch_assoc y nos traiga un array asociativo
            //y se lo asignemos a $registro
            // $array[] = $registro['titulo'];
            // debuggear($array);
            // exit;
            $array[] = static::crearObjeto($registro);
        }
        // debuggear($array);

        //Liberar la memoria
        $resultado->free();
        //Retornar los resultados
        return $array;
    }

    //Ahora, de nuevo, tenemos que tener objeto, no arreglos
    protected static function crearObjeto($registro){
        //Nota: new self significa la clase PADRE es decir una nueva PROPIEDAD
        //Recordando que este sera una nueva instancia con valores vacios, en el forEach vamos a iterar y darle esos valores
        //a nuestro nuevo objeto instanciado
        // $objeto = new self;
        //ESTO DE ARRIBA AHORA ES LO DE ABAJO GRACIAS A QUE ESTAMOS HACIENDO REFERENCIA A ACTIVE RECORD 
        $objeto = new static;
        // debuggear($objeto);
        //Vamos a iterar, comprobando primero con property_exists(), esta funcion toma 2 parametros, el primero es 
        //el objeto/clase, el segundo es que propiedad EXISTE YA EN ESE OBJETO, porque sabemos que 
        //Al instanciar una nueva clase para nuestro objeto, este tiene propiedades que ya definimos(arriba en nuestra clase), 
        //vamos a COMPROBAR
        //con este segundo parametro si ese existe en las propiedades de nuestra clase, si si entonces vamos a asignar un value
        //a cada uno de nuestras propiedades
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        // debuggear($objeto);
        return $objeto;
        //NOTA IMPORTANTISIMA: PORQUE HICIMOS TANTA CHINGADERA ARRIBA? CUANDO CON mysqli SOLO ERA TRAERNOS EL FETCH ASSOC 
        //Y SE CHINGO?, PORQUE ESTAMOS TRABAJANDO CON ACTIVE RECORD, ENTONCES TENEMOS QUE TENER UN OBJETO IGUAL A LO QUE HAY
        //EN LA DB, PORQUE CON FETCH ASSOC ESTE NOS REGRESA UN ARRAY ASOCIATIVO, NO UN OBJETO
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []){
        // debuggear($args);
        foreach($args as $key=>$value){
            //$this hace referencia al objeto, en este caso el de la variable $propiedad que encontramos con el metodo Propiedad::find($id);
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}