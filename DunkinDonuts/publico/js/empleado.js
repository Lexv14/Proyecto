document.addEventListener('DOMContentLoaded', () => {
    // Cargar dinámicamente la sección de mensajes si estamos en esa página
    const listaMensajes = document.getElementById('listaMensajes');
    if (listaMensajes) {
        cargarMensajes(listaMensajes);
    }
});

function cargarMensajes(container) {
    // El fetch ahora apunta al nuevo enrutador
    fetch('index.php?controlador=admin&accion=obtenerMensajesAjax')
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                container.innerHTML = '<p>No hay mensajes disponibles.</p>';
                return;
            }
            container.innerHTML = '';
            data.forEach(msg => {
                const div = document.createElement('div');
                div.className = 'mensaje-item'; // Usar una clase para estilo
                div.innerHTML = `
                    <p><strong>De:</strong> ${msg.nombre}</p>
                    <p><strong>Mensaje:</strong> ${msg.mensaje}</p>
                    <p class="fecha-mensaje">Enviado el: ${msg.fecha}</p>
                `;
                container.appendChild(div);
            });
        })
        .catch(error => {
            container.innerHTML = '<p>Error al cargar los mensajes.</p>';
            console.error('Error:', error);
        });
}

function confirmarEliminacionPeticion(event) {
    if (!confirm('¿Seguro que quieres eliminar esta petición de la lista?')) {
        event.preventDefault();
    }
}