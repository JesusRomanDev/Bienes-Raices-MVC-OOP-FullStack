<main class="contenedor seccion">
        <h1>Actualizar Vendedor</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>
        <?php foreach($erroresAntes as $error) : ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>

        <?php endforeach; ?>
        <!-- el action se recomienda al menos ahorita iniciando que sea en la misma ruta de donde se esta haciendo la peticion-->
        <!-- O COMO EN EL EJEMPLO DE AQUI ABAJO EDITAR LA RUTA -->
        <!-- CADA INPUT DEBE LLEVAR UN NAME, DE PREFERENCIA EL NAME DEBE SER IGUAL AL FOR E ID DEL RESPECTIVO -->
        <form class="formulario" method="POST" action="/vendedores/actualizar?id=<?php echo $vendedor->id ?>">
            <?php include __DIR__ . '/formulario.php' ?>
            <input type="submit" value="Guardar Cambios" class="margins boton boton-verde">
        </form>
    </main>