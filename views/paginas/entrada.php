<main class="contenedor seccion contenido-centrado">
        <h1><?php echo $anuncio->titulo ?></h1>

   
        <picture>
            <!-- <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg"> -->
            <img loading="lazy" src="build/img/<?php echo $anuncio->imagen ?>.jpg" alt="imagen de la propiedad">
        </picture>

        <p class="informacion-meta">Escrito el: <span><?php echo $anuncio->fecha ?></span> por: <span><?php echo $anuncio->autor ?></span> </p>


        <div class="resumen-propiedad">
            <p><?php echo $anuncio->descripcion ?></p>
        </div>
    </main>