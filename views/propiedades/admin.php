<main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php $status = mostrarNotificacion($resultado); ?>
        <!-- Tenemos que convertir a un int el $resultado que hasta ahora era un STRING -->
        <?php if($status) :?>
        <p class="alerta exito"><?php echo $status; ?></p>
        <?php endif ?>

        <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/vendedores/crear" class="boton boton-amarillo">Nuevo Vendedor</a>

        <h2>Propiedades</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!-- Antes de nuestro TR debemos escribir el codigo que ira ITERANDO EN LA DB, porque cadas registro necesita un tr -->
                <?php foreach($propiedades as $propiedad) :?>
                    <tr>
                        <td><?php echo $propiedad->id?></td>
                        <td><?php echo $propiedad->titulo?></td>
                        <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>.jpg" class="imagen-tabla" alt=""></td>
                        <td>$<?php echo $propiedad->precio; ?></td>
                        <td>
                            <!-- En vez de tener solo el enlace(a), mejor hay que tener un form y dentro un submit -->
                            <form method="POST" action="/propiedades/eliminar">
                                <!-- Se creo otro input, en este caso hidden, para que al momento de enviarse este contenga
                                algo, ya que en el input de abajo nuestro value es 'Eliminar', entonces para que el form pueda
                                agarrar algo se creo otro input para que contenga otro value -->
                                <!-- Entonces como el form no tiene un action, lo enviara a este mismo archivo, se podria 
                                decir que hace f5 con el id, entonces vamos a comprobar arriba que el metodo sea de tipo POST  para poder eliminar ese id-->
                                <input type="hidden" name="id" value="<?php echo $propiedad->id ?>">
                                <input type="hidden" name="tipo" value="propiedad">
                                <input type="submit" class="boton-rojo-block w-100" value="Eliminar">
                            </form>
                            <a href="/propiedades/actualizar?id=<?php echo $propiedad->id ?>" class="boton-verde-block">Actualizar</a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!-- Antes de nuestro TR debemos escribir el codigo que ira ITERANDO EN LA DB, porque cadas registro necesita un tr -->
                <?php foreach($vendedores as $vendedor) :?>
                    <tr>
                        <td><?php echo $vendedor->id?></td>
                        <td><?php echo $vendedor->nombre . " " . $vendedor->apellido?></td>
                        <td>$<?php echo $vendedor->telefono; ?></td>
                        <td>
                            <!-- En vez de tener solo el enlace(a), mejor hay que tener un form y dentro un submit -->
                            <form method="POST" action="/vendedores/eliminar">
                                <!-- Se creo otro input, en este caso hidden, para que al momento de enviarse este contenga
                                algo, ya que en el input de abajo nuestro value es 'Eliminar', entonces para que el form pueda
                                agarrar algo se creo otro input para que contenga otro value -->
                                <!-- Entonces como el form no tiene un action, lo enviara a este mismo archivo, se podria 
                                decir que hace f5 con el id, entonces vamos a comprobar arriba que el metodo sea de tipo POST  para poder eliminar ese id-->
                                <input type="hidden" name="id" value="<?php echo $vendedor->id ?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block w-100" value="Eliminar">
                            </form>
                            <a href="/vendedores/actualizar?id=<?php echo $vendedor->id ?>" class="boton-verde-block">Actualizar</a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
</main>