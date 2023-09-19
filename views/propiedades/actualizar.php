<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <?php foreach ($errores as $item) : ?>
        <div class="alerta error">
            <?php echo $item; ?>
        </div>
    <?php endforeach; ?>

    

    <a href="/admin" class="boton boton-verde">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data" action="/propiedades/actualizar">
        <?php include __DIR__ . '/formulario.php';  ?><!-- __DIR__ apunta hasta la carpeta propiedades; es decir apunta a la carpeta donde esta siendo llamdo -->
        <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
    </form>
</main>