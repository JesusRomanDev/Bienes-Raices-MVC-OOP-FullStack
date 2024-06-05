<fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" placeholder="Titulo Propiedad" name="titulo" id="titulo" value="<?php echo s($propiedad->titulo) ?>">

                <label for="precio">Precio:</label>
                <input type="number" placeholder="Precio Propiedad" name="precio" id="precio" value="<?php echo s($propiedad->precio) ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" accept="image/jpeg, image/png" id="imagen" name="imagen">
                <?php if($propiedad->imagen) { ?>
                    <img src="/imagenes/<?php echo $propiedad->imagen ?>.jpg" class="imagen-small" alt="">
                <?php } ?>

                <label for="descripcion">Descripcion:</label>
                <!-- Nota: el value no existe en el TEXTAREA, en vez se coloca DENTRO DEL TEXTAREA directo sin el texto value -->
                <textarea id="descripcion" name="descripcion" ><?php echo s($propiedad->descripcion); ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion de la Propiedad</legend>
                <label for="habitaciones">Habitaciones:</label>
                <input min="1" max="9" type="number" name="habitaciones" placeholder="Ej. 3" id="habitaciones" value="<?php echo s($propiedad->habitaciones) ?>">

                <label for="wc">Baños:</label>
                <input min="1" max="5" name="wc" type="number" placeholder="Ej. 3" id="wc" value="<?php echo s($propiedad->wc) ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input min="1" max="5" type="number" name="estacionamiento" placeholder="Ej. 3" id="estacionamiento" value="<?php echo s($propiedad->estacionamiento) ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor:</legend>

                <label for="vendedor">Vendedor</label>
                <select name="vendedorId" id="vendedor">
                    <option selected value="">--Seleccione Vendedor--</option>
                    <?php foreach($vendedores as $vendedor) { ?>
                        <option <?php echo $vendedor->id === $propiedad->vendedorId ? 'selected' : '' ?> value="<?php echo s($vendedor->id) ?>">
                            <?php echo s($vendedor->nombre) . " " . $vendedor->apellido ?>
                        </option>
                    <?php } ?>
                </select>
            </fieldset>