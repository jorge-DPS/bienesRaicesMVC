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