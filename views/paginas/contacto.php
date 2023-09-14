<main class="contenedor seccion contenido-centrado">
    <h1>contacto</h1>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>

    <h2>Llene el formulario de Contacto</h2>

    <form class="formulario" action="/contacto" method="POST">
        <fieldset>
            <legend>Informacion Personal</legend>
            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu nombre" id="nombre" name="contacto[nombre]" required>

            <label for="email">Correo</label>
            <input type="email" placeholder="Tu correo" id="email" name="contacto[email]" required>

            <label for="telefono">Teléfono</label>
            <input type="tel" placeholder="Tu telefono" id="telefono" name="contacto[telefono]">

            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="contacto[mensaje]" required></textarea>
        </fieldset>

        <fieldset>
            <legend>Informacion sobre la propiedad</legend>

            <label for="opciones">Vende o Compra:</label>
            <select id="opciones" name="contacto[tipo]" required>
                <option value="" disabled>-- Seleccione --</option>
                <option value="compra">Compra</option>
                <option value="vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" name="contacto[precio]" required>

        </fieldset>

        <fieldset>
            <legend>Informacion sobre la propiedad</legend>

            <p>Como desea ser Contactado</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input name="contacto" type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" required>

                <label for="cotactar-email">Correo</label>
                <input name="contacto" type="radio" value="email" id="contactar-email" name="contacto[contacto]" required>
            </div>

            <p>Si Eligio teléfono, elija la fecha y la hora</p>
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora:</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>