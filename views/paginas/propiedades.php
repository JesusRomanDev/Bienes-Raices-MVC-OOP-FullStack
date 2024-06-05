<main class="contenedor seccion">

<h2>Casas y Depas en Venta</h2>
<!-- Mostrando los anuncios con un template -->
<?php
    //Ahora bien, en index.php el limite le dijimos que fuera 3, pero aqui como se muestran todos los anuncios
    //podemos decirle que sean mas de 3, por ejemplo 10
    $limite = 10;
    include __DIR__ . '/listado.php'; 
?>
</main>