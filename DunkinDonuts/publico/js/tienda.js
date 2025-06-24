document.addEventListener('DOMContentLoaded', () => {

    // --- Lógica para el toggle de contraseña en login y registro ---
    const togglePassword = document.querySelector('.toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const passwordInput = document.getElementById('contraseña');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // --- Lógica para el chat flotante ---
    const chatIcon = document.querySelector('.chat-icon');
    const chatPopup = document.getElementById('chatPopup');
    if (chatIcon && chatPopup) {
        chatIcon.addEventListener('click', () => {
            chatPopup.classList.toggle('visible');
        });
    }

    // --- Lógica para el mapa de ubicación ---
    const locationSelect = document.getElementById('locationSelect');
    const mapFrame = document.getElementById('mapFrame');
    if (locationSelect && mapFrame) {
        locationSelect.addEventListener('change', () => {
            mapFrame.src = locationSelect.value;
        });
    }

    // --- Lógica para formulario de finalizar compra ---
    const tipoPagoSelect = document.getElementById('tipo_pago');
    if (tipoPagoSelect) {
        tipoPagoSelect.addEventListener('change', mostrarCamposPago);
    }
    
    const formCompra = document.querySelector('form[action*="procesarCompra"]');
    if(formCompra) {
        formCompra.addEventListener('submit', validarFormularioCompra);
    }
});

function mostrarCamposPago() {
    const tipoPago = document.getElementById("tipo_pago").value;
    document.getElementById("campos_tarjeta").style.display = tipoPago === "tarjeta" ? "block" : "none";
    document.getElementById("campos_paypal").style.display = tipoPago === "paypal" ? "block" : "none";
}

function validarFormularioCompra(event) {
    const tipoPago = document.getElementById("tipo_pago").value;
    if (tipoPago === "tarjeta") {
        const num = document.getElementById("numero_tarjeta").value;
        const fecha = document.getElementById("fecha_expiracion").value;
        const cvv = document.getElementById("cvv").value;
        if (!num || !fecha || !cvv) {
            alert("Por favor, completa todos los datos de la tarjeta.");
            event.preventDefault(); // Detiene el envío del formulario
            return false;
        }
    }
    if (tipoPago === "paypal") {
        const correo = document.getElementById("correo_paypal").value;
        if (!correo) {
            alert("Por favor, ingresa el correo de PayPal.");
            event.preventDefault(); // Detiene el envío del formulario
            return false;
        }
    }
    return true;
}