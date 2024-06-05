<main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesion</h1>
        <?php foreach($errores as $error) :?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach;?>

        <form method="POST" class="formulario" action="/login">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <!-- Tenemos que recordar que los forms al tener el metodo POST deben llevar un name los inputs
                para que asi al enviarse, el array asociativo tenga como propiedades estos 2(email y password) -->
                <input type="email" placeholder="Tu Email" name="email" id="email">

                <label for="password">Password:</label>
                <input type="password" placeholder="Tu Password" name="password" id="password">
            </fieldset>

            <input type="submit" value="Iniciar Sesion" class="margins boton-verde" name="" id="">
        </form>
    </main>