<div class="container mt-3">
    <h1>Editar Perfil</h1>
    <a href="/medicos/panel" class="btn btn-secondary mb-2">Volver al Panel</a>

    <?php foreach ($errores as $error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endforeach; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="card">
            <h3>Información Personal</h3>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    value="<?php echo s($medico->nombre); ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control"
                    value="<?php echo s($medico->apellido); ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control"
                    value="<?php echo s($medico->telefono); ?>" required>
            </div>
            <div class="form-group">
                <label for="whatsapp">WhatsApp</label>
                <input type="tel" name="whatsapp" id="whatsapp" class="form-control"
                    value="<?php echo s($medico->whatsapp); ?>" required>
            </div>

            <h3 class="mt-2">Información Profesional</h3>
            <div class="form-group">
                <label for="especialidad">Especialidad</label>
                <input type="text" name="especialidad" id="especialidad" class="form-control"
                    value="<?php echo s($medico->especialidad); ?>" required>
            </div>
            <div class="form-group">
                <label for="biografia">Biografía</label>
                <textarea name="biografia" id="biografia" class="form-control"
                    rows="5"><?php echo s($medico->biografia); ?></textarea>
            </div>
            <div class="form-group">
                <label for="servicios">Servicios (Separados por coma o salto de línea)</label>
                <textarea name="servicios" id="servicios" class="form-control"
                    rows="5"><?php echo s($medico->servicios); ?></textarea>
            </div>

            <h3 class="mt-2">Foto de Perfil</h3>
            <?php if ($medico->foto_perfil): ?>
                <img src="/imagenes/medicos/<?php echo $medico->foto_perfil; ?>" class="imagen-small mb-1">
            <?php endif; ?>
            <input type="file" name="foto_perfil" class="form-control" accept="image/jpeg, image/png">

            <button type="submit" class="btn btn-primary mt-2">Guardar Cambios</button>
        </div>
    </form>
</div>