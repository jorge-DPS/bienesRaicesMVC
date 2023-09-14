<?php
if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false; //-> en ta caso si no esta autenticado le asugna un false; es com un if

if (!isset($inicio)) {
    $inicio = false;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>

<body>

    <header class="header <?php echo $inicio  ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="../../index.php">
                    <img src="/build/img/logo.svg" alt="Logotipo ">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="dark mode">
                    <nav class="navegacion">
                        <a href="/nosotros">Nosotros</a>
                        <a href="/propiedades">Anuncios</a>
                        <a href="/blog">Blog</a>
                        <a href="/contacto">Contacto</a>
                        <?php if ($auth) : ?>
                            <a href="/cerrar-sesion">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>


            </div> <!-- .Barra -->
            <?php if ($inicio) { ?>
                <h1>Venta de casas y departamentos exclusivos de Lujo</h1>
            <?php } ?>
        </div>
    </header>

    <?php echo $contenido; ?> <!-- aqui se injecta todo de la carpeta de propiedades -->

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros.php">Nosotros</a>
                <a href="anuncios.php">Anuncios</a>
                <a href="blog.php">Blog</a>
                <a href="contacto.php">Contacto</a>
            </nav>
        </div>

        <!-- <?php
                // $fecha = date('Y') //-> fecha
                ?> -->

        <p class="copyright">Los derechos reservados <?php echo date('Y'); ?> &copy;</p>
    </footer>

    <script src="../build/js/bundle.min.js"></script>
</body>

</html>