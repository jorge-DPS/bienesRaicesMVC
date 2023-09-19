<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>Email y password</legend>

            <label for="email">Correo</label>
            <input type="email" name="email" placeholder="Tu correo" id="email">

            <label for="password">Passeord</label>
            <input type="password" name="password" placeholder="Tu Contraseña" id="password">
        </fieldset>
        <input type="submit" value="iniciar Sesión" class="boton boton-verde">
    </form>

</main>