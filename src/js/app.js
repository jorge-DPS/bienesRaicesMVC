document.addEventListener('DOMContentLoaded', function () {
    eventoEscuchar();

    modoOscuro();
});

function modoOscuro() {

    const prefiereModooscuro = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereModooscuro.matches);

    if (prefiereModooscuro.matches) {
        document.body.classList.add('dark-mode')
    } else {
        document.body.classList.remove('dark-mode')
    }

    prefiereModooscuro.addEventListener("change", function () {
        /* aqui lo que hace es poner la apariencia degub el usuario calro o oscuro */
        if (prefiereModooscuro.matches) {
            document.body.classList.add('dark-mode')
        } else {
            document.body.classList.remove('dark-mode')
        }
    });

    const botonModoOscuro = document.querySelector(".dark-mode-boton");
    botonModoOscuro.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    });
};

function eventoEscuchar() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResposive);

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
};

function navegacionResposive() {
    const navegacion = document.querySelector('.navegacion');

    /* navegacion.classList.toggle('mostrar') */ /* hace lo mismo que esta abajo en el if */ 
    if (navegacion.classList.contains('mostrar')) {
        navegacion.classList.remove('mostrar')
    } else {
        navegacion.classList.add('mostrar')
    }
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <label for="Numero telefono">Teléfono</label>
            <input type="tel" placeholder="Tu telefono" id="telefono" name="contacto[telefono]">

            <p>Eliga la fecha y la hora para la llamada</p>
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora:</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
        <label for="email">Correo</label>
            <input type="email" placeholder="Tu correo" id="email" name="contacto[email]">
        `;
    }
 
}