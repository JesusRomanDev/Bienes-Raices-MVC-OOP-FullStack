<main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>

        <?php foreach($anuncios as $anuncio) : ?>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <!-- <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpeg"> -->
                        <!-- <img loading="lazy" src="build/img/blog1.jpg" alt="Texto Entrada Blog"> -->
                        <img loading="lazy" src="build/img/<?php echo $anuncio->imagen ?>.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada?id=<?php echo $anuncio->id ?>">
                        <h4><?php echo $anuncio->titulo; ?></h4>
                        <p>Escrito el: <span><?php echo $anuncio->fecha; ?></span> por: <span><?php echo $anuncio->autor; ?></span> </p>

                        <p><?php echo substr($anuncio->descripcion,1,100) ?> <span>   Ver mas...</span></p>
                    </a>
                </div>
            </article>
        <?php endforeach?>
    </main>