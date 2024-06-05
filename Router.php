<?php
//Router.php inicia con mayusuclas porque va a ser una clase
namespace MVC;

class Router{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
        // debuggear($this->rutasGET);
    }

    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
        // debuggear($this->rutasPOST);
    }

    public function comprobarRutas()
    {
        //Iniciando la session
        session_start();

        $auth = $_SESSION['login'] ?? null;

        //ARREGLO DE RUTAS PROTEGIDAS
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', 'vendedores/crear', 'vendedores/actualizar', 'vendedores/eliminar'];


        // debuggear($this->rutasGET);
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
        // debuggear($urlActual);
        if($metodo === 'GET'){
            //Aqui mapeamos la funcion que le toca con nuestra variable $urlActual, PUEDE QUE LA URL ACTUAL NO EXISTA, ENTONCES
            //ESE VALOR ESTARA VACIO YA QUE NO SE ASIGNO NUNCA NADA A ESA URL, por lo tanto la variable $fn estara vacia o no
            //dependiendo
            $fn = $this->rutasGET[$urlActual] ?? null;
            // debuggear($fn);
        } 

        if($metodo === 'POST'){
            $fn = $this->rutasPOST[$urlActual] ?? null;
            // debuggear($fn);
        } 

        //Proteger la ruta ADMIN
        //in_array nos permite revisar un elemento en un arreglo y nos retorna true o false
        //entonces va a buscar la urlActual que es /admin en el arreglo de $rutas_protegidas
        //entonces significa que estamos visitando una ruta protegida
        //A eso le agregamos que SI TAMPOCO ESTAMOS AUTENTICADOS NOS MANDE A "/";
        //Entonces si estamos en una ruta protegia YYYYYY no estamos autenticados mandamos a inicio
        if(in_array($urlActual, $rutas_protegidas) && !$auth){
            header('Location: /');
        }elseif($urlActual === '/login' && $auth){
            header('Location: /');
        }

        if($fn){
            //La URL existe y hay una funcion asociada

            //Ahora bien aqui vale verga porque call_user_func usa como PRIMER parametro una funcion callback, pero tenemos
            //que recordar que nuestra variable $fn es un ARRAY, ESTO ES PORQUE ESTA FUNCION DE CAGADA ASI LO PIDE, UN PINCHE
            //PUTO ARRAY, este array como primer elemento es el $classname y como segundo elemento es el $method, osease
            //en pinche perro resumen [PropiedadController::class, 'index'] por tomar como ejemplo
            //Ahora bien el SEGUNDO PARAMETRO, el $this es un parámetro que recibe la función que se llama, si lo eliminas php te avisa que la función index requiere un parámetro.
            //ENTONCESSSSSSSSSS EL THIS ES EL PARAMETRO DE EL METODO INDEX DEL ARCHIVO PropiedadController.php
            //public static function index(Router $router), como vemos con el $this le estamos dando la referencia de toda esa instancia
            // ------------------------LLAMA A LA FUNCION INDEX/CREAR/ACTUALIZAR DEL CONTROLADOR------------------------
            call_user_func($fn, $this);
            // echo "Hola";
        }else{
            echo "Pagina no encontrada";
        }

    }
    //Muestra una vista
    public function render($view, $datos = []){
        // echo "desde render";
        foreach($datos as $key=> $value){
            $$key = $value;
        }
        ob_start();
        include __DIR__ . "/views/$view.php";
        //$contenido va a obtener el include de arriba ya que fue iniciado por ob_start() y aqui abajo con ob_get_clean() se lo 
        //asignamos a la variable
        $contenido = ob_get_clean();

        include __DIR__ . '/views/layout.php';
        $variableMamalona = "AAAAAAAAAAAAAAAA";
    }
}