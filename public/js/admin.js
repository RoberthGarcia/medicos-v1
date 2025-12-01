/**
 * JavaScript para el panel de administración
 * Maneja confirmaciones y mejoras de UX
 */

document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    // CONFIRMACIÓN PARA ELIMINAR MÉDICO
    // ============================================
    const deleteButtons = document.querySelectorAll('.btn-delete-medico');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const nombre = this.dataset.nombre;

            const confirmado = confirm(
                `⚠️ ¿ESTÁS SEGURO?\n\n` +
                `Estás a punto de eliminar al Dr. ${nombre}\n\n` +
                `Esta acción eliminará:\n` +
                `• Su perfil completo\n` +
                `• Su foto de perfil\n` +
                `• Su galería de imágenes\n` +
                `• Toda su información premium\n\n` +
                `Esta acción NO se puede deshacer.`
            );

            if (confirmado) {
                form.submit();
            }
        });
    });

    // ============================================
    // CONFIRMACIÓN PARA TOGGLE (ACTIVAR/DESACTIVAR)
    // ============================================
    const toggleButtons = document.querySelectorAll('.btn-toggle-medico');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const nombre = this.dataset.nombre;
            const accion = this.dataset.accion; // "activar" o "desactivar"

            const confirmado = confirm(
                `¿Deseas ${accion} al Dr. ${nombre}?\n\n` +
                (accion === 'desactivar' ?
                    'El perfil no aparecerá en el directorio público.' :
                    'El perfil volverá a aparecer en el directorio público.')
            );

            if (confirmado) {
                form.submit();
            }
        });
    });

    // ============================================
    // AUTO-OCULTAR ALERTAS DESPUÉS DE 5 SEGUNDOS
    // ============================================
    const alerts = document.querySelectorAll('.alert-auto-hide');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // ============================================
    // PREVENIR DOBLE SUBMIT EN FORMULARIOS
    // ============================================
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function () {
            const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                if (submitBtn.tagName === 'BUTTON') {
                    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Procesando...';
                }
            }
        });
    });
});

// ============================================
// FUNCIÓN AUXILIAR: MOSTRAR MENSAJE TEMPORAL
// ============================================
function mostrarMensaje(texto, tipo = 'success') {
    const mensaje = document.createElement('div');
    mensaje.className = `alert alert-${tipo} alert-auto-hide`;
    mensaje.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    mensaje.textContent = texto;

    document.body.appendChild(mensaje);

    setTimeout(() => {
        mensaje.style.transition = 'opacity 0.3s';
        mensaje.style.opacity = '0';
        setTimeout(() => mensaje.remove(), 300);
    }, 5000);
}
