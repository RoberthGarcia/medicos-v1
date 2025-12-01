<?php
/**
 * Sistema de mensajes/alertas para feedback de usuario
 * Muestra mensajes basados en parámetros GET
 */

// Mensajes de éxito
$mensajes_exito = [
    'created' => 'Médico registrado exitosamente',
    'updated' => 'Médico actualizado exitosamente',
    'deleted' => 'Médico eliminado exitosamente',
    'activated' => 'Médico activado exitosamente',
    'deactivated' => 'Médico desactivado exitosamente'
];

// Mensajes de error
$mensajes_error = [
    'invalid_id' => 'ID de médico inválido',
    'not_found' => 'Médico no encontrado',
    'delete_failed' => 'Error al eliminar el médico',
    'toggle_failed' => 'Error al cambiar el estado del médico',
    'upload_failed' => 'Error al subir la imagen'
];

// Mostrar mensaje de éxito
if (isset($_GET['success']) && isset($mensajes_exito[$_GET['success']])):
    ?>
    <div class="alert alert-success alert-auto-hide" style="margin-bottom: 20px;">
        <strong>✓ Éxito:</strong> <?php echo $mensajes_exito[$_GET['success']]; ?>
    </div>
<?php endif; ?>

<?php
// Mostrar mensaje de error
if (isset($_GET['error']) && isset($mensajes_error[$_GET['error']])):
    ?>
    <div class="alert alert-danger alert-auto-hide" style="margin-bottom: 20px;">
        <strong>✗ Error:</strong> <?php echo $mensajes_error[$_GET['error']]; ?>
    </div>
<?php endif; ?>