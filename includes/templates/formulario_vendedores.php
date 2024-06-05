<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" placeholder="Nombre del Vendedor" name="nombre" id="nombre" value="<?php echo s($vendedor->nombre) ?>">

    <label for="apellido">Apellido:</label>
    <input type="text" placeholder="Apellido del Vendedor" name="apellido" id="apellido" value="<?php echo s($vendedor->apellido) ?>">
</fieldset>

<fieldset>
    <legend>Datos Adicionales</legend>

    <label for="telefono">Telefono:</label>
    <input type="text" placeholder="Telefono del Vendedor" name="telefono" id="telefono" value="<?php echo s($vendedor->telefono) ?>">
</fieldset>