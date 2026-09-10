// Esperamos a que todo el HTML de la página haya cargado
document.addEventListener('DOMContentLoaded', function() {
    // Buscamos el botón y el menú por sus IDs
    const btnMenu = document.getElementById('btnMenu');
    const menuPrincipal = document.getElementById('menuPrincipal');

    // Escuchamos el evento de "clic" en el botón
    if(btnMenu && menuPrincipal) {
        btnMenu.addEventListener('click', function() {
            // La función toggle agrega la clase 'activo' si no la tiene, y la quita si ya la tiene
            menuPrincipal.classList.toggle('activo');
        });
    }
});