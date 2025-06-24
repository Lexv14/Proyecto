document.addEventListener('DOMContentLoaded', () => {
    // Cargar dinámicamente la sección de gestión de usuarios si estamos en esa página
    if (document.getElementById('tablaUsuarios')) {
        cargarUsuarios();
    }
    
    // Cargar el historial de peticiones si estamos en esa página
    if (document.getElementById('historialAceptados')) {
        mostrarHistorial();
    }
});

function cargarUsuarios() {
    // Esta función ahora será utilizada por gestion_usuarios.php para cargar la tabla
    // El fetch y la manipulación del DOM se pueden mantener aquí para hacer la tabla dinámica
    // sin recargar la página, si se desea. Por simplicidad en la refactorización inicial,
    // el PHP puede generar la tabla directamente.
    console.log("Cargando lista de empleados...");
}

// Lógica para el historial de peticiones (antes en localStorage, ahora simulado)
// En una implementación real, esto haría llamadas fetch al PeticionControlador
function mostrarHistorial() {
    console.log("Mostrando historial de peticiones...");
    // La lógica de localStorage se elimina. El servidor ahora renderiza el historial.
    // Se pueden añadir funciones fetch para actualizar el estado sin recargar la página.
}

function confirmarEliminacion(event, usuario) {
    if (!confirm(`¿Estás seguro de que quieres eliminar al usuario "${usuario}"?`)) {
        event.preventDefault();
    }
}