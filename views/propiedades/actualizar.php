<main class="contenedor seccion">
    <h1>Actualizar</h1>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <a href="/admin" class="boton boton-verde">Volver</a>

        
        <?php foreach($erroresAntes as $error) : ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <?php include __DIR__ . '/formulario.php' ?>
        <input type="submit" value="Actualizar Propiedad" class="margins boton boton-verde"> 
    </form>
</main>