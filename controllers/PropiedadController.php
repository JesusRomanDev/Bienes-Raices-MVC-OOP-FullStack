<?php

    namespace Controllers;
    use MVC\Router;
    use Intervention\Image\ImageManagerStatic as Image;

    use Model\Propiedad;
    use Model\Vendedor;

class PropiedadController{
    public static function index(Router $router){
        // echo "desde index";
        //Consultando la DB para pasarselo a la vista con la variable $propiedades
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

        //El controlador aqui va a mandar llamar las vistas, ENTONCES REGRESA CON EL ROUTER Y ESTE MANDA LLAMAR LA VISTA
        $router->render('propiedades/admin', [
            // "mensaje" => "desde la vista"
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router){
        // echo "desde crear";
        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // debuggear($_POST);
            $propiedad = new Propiedad($_POST);
                
                //Generando un nombre unico para la imagen
                //Esta linea de abajo se puede reutilizar en diferentes proyectos para generar un name random a las imagenes
                $nombreImagen = md5(uniqid(rand(), true));
                
                // debuggear($_FILES);
                //Setear la imagen
                //Realiza un resize a la imagen con intervention
                if($_FILES['imagen']['tmp_name']){
                    //Lo que estamos haciendo aqui es solamente SETEAR POR ASI DECIRSE LA IMAGEN, HASTA QUE HAGAMOS UN 
                    //$image->save() es cuando ya la guardamos en el servidor, solo y solo si... no hay errores devueltos
                    $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
                    //Dandole el nombre del archivo
                    $propiedad->setImagen($nombreImagen);
                }
                // debuggear($propiedad);
    
                //Validando
                //Nota: propiedad llama el metodo validar(), y esta funcion nos retorna los errores, entonces podemos asignarlas
                //a una variable
                $errores = $propiedad->validar();
                
                //Revisar que el array de errores este vacio
                if(empty($errores)){ //si esta vacio de errores retorna TRUE

                    //Crear la carpeta para subir imagenes ANTES DE GUARDAR LA IMAGEN
                    if(!is_dir(CARPETA_IMAGENES)){
                        mkdir(CARPETA_IMAGENES);
                    }
                    
                    //Guarda la imagen en el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen . '.jpg');

                    //Guarda en la DB
                    //Guardando los datos con un metodo
                    $resultado = $propiedad->guardar();
                    // debuggear($resultado);
                    if($resultado){
                        header('Location: /admin?resultado=1');
                    }
            } 
        }
        $erroresAntes = Propiedad::getErrores();

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'erroresAntes' => $erroresAntes
        ]);
    }

    public static function actualizar(Router $router){
        //Esta FUNCION es para no tener aqui en nuestro controlador algo como lo que tuvimos en este mismo proyecto pero sin MVC
        // $id = $_GET['id'];
        // $id= filter_var($id, FILTER_VALIDATE_INT);
        // if(!$id){
            //     header('Location: /admin');
            // }
            
        //Validando que ese id sea un int y no un string, ya que alguien puede poner en la url un "hola" por ejemplo
        //modificando la misma variable $id
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Asignar atributos
            $propiedad->sincronizar($_POST);

            //Validacion
            $errores= $propiedad->validar();
    
            //Subida de archivos
    
            //Generando un nombre unico para la imagen
            //Esta linea de abajo se puede reutilizar en diferentes proyectos para generar un name random a las imagenes
            $nombreImagen = md5(uniqid(rand(), true));
            
            if($_FILES['imagen']['tmp_name']){
                $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
                //Dandole el nombre del archivo
                $propiedad->setImagen($nombreImagen);
            }
    
            //Revisar que el array de errores este vacio
            if(empty($errores)){ //si esta vacio de errores retorna TRUE
                if($_FILES['imagen']['tmp_name']){
                    $image->save(CARPETA_IMAGENES . $nombreImagen . '.jpg');
                }
                $resultado = $propiedad->guardar();
                // debuggear($resultado);
                //Insertando en la base de datos
                // $query = "UPDATE propiedades SET titulo= '$titulo', precio='$precio', imagen= '$nombreImagen', descripcion='$descripcion', habitaciones= $habitaciones, wc=$wc, estacionamiento=$estacionamiento, vendedorId=$vendedorId where id = $id";
                
                // echo $query;
                //Almacenandolo en la base de datos
                // $resultado = mysqli_query($db, $query);
                if($resultado){
                    header('Location: /admin?resultado=2');
                    // echo "registro";
                }
            }
            
            //Arreglo con mensajes de errores para la validacion
            $erroresFuera= Propiedad::getErrores();
        }
        
        $erroresAntes = Propiedad::getErrores();

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
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
                    $propiedad = Propiedad::find($id);
                    $resultado = $propiedad->eliminar();
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