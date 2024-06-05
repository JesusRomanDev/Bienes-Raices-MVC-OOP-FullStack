<?php
//Pasos de siempre(o casi siempre)
    //1-Importar la conexion a la DB
    // require 'includes/config/database.php';
    // $db = conectarDB();
    // //2-Consultar
    // //Nota: el $limite se definio en el origen donde se mando llamar este anuncios.php
    // $query = "SELECT * FROM propiedades LIMIT $limite";
    // //3-Obtener el resultado
    // $resultado = mysqli_query($db, $query);
    use Model\Propiedad;

    // debuggear($_SERVER);
    if($_SERVER['SCRIPT_NAME'] === '/propiedades'){
        $propiedades = Propiedad::all();
    }else{
        $propiedades = Propiedad::get(3);
    }


?>

<div class="contenedor-anuncios">
    <!-- 4-Inyectar el resultado -->
    <?php foreach($propiedades as $propiedad ):?>
        <div class="anuncio">
            <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen . '.jpg'; ?>" alt="anuncio">

            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo; ?></h3>
                <p><?php echo $propiedad->descripcion; ?></p>
                <p class="precio">$<?php echo $propiedad->precio; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad->wc; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?php echo $propiedad->estacionamiento; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?php echo $propiedad->habitaciones; ?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div><!--.contenido-anuncio-->
        </div><!--anuncio-->
    <?php endforeach; ?>

</div> <!--.contenedor-anuncios-->


    <!-- //5-Cerrar la conexion
    mysqli_close($db); -->
    <!-- NOTA: ESTE PASO DE ARRIBA YA NO SE HACE GRACIAS A QUE EN CONSULTARSQL($QUERY) EN ACTIVE RECORD
    TENEMOS UN $RESULTADO->FREE(); ESO NOS AYUDA A CERRAR LA CONEXION DB -->