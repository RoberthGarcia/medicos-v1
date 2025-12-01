<div class="container mt-3">
    <h1>Galería Premium</h1>
    <a href="/medicos/panel" class="btn btn-secondary mb-2">Volver al Panel</a>

    <div class="card mb-2">
        <h3>Subir Nueva Imagen</h3>
        <form method="POST" action="/medicos/galeria/subir" enctype="multipart/form-data">
            <div class="form-group">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*" required>
            </div>
            <div class="form-group">
                <label>Descripción (Opcional)</label>
                <input type="text" name="descripcion" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Subir Imagen</button>
        </form>
    </div>

    <div class="card">
        <h3>Mis Imágenes</h3>
        <div class="grid-3">
            <?php foreach ($imagenes as $imagen): ?>
                <div class="card">
                    <img src="/imagenes/galerias/<?php echo $imagen->nombre_archivo; ?>"
                        style="width: 100%; height: 150px; object-fit: cover;">
                    <p class="mt-1"><?php echo $imagen->descripcion; ?></p>
                    <form method="POST" action="/medicos/galeria/eliminar">
                        <input type="hidden" name="id" value="<?php echo $imagen->id_galeria; ?>">
                        <button type="submit" class="btn btn-danger btn-block btn-sm">Eliminar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>