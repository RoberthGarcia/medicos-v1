<div class="container mt-3">
    <div class="card">
        <h2 class="text-center">Información Premium</h2>
        <a href="/medicos/panel" class="btn btn-secondary mb-2">Volver al Panel</a>

        <?php foreach ($errores as $error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endforeach; ?>

        <form method="POST">
            <fieldset>
                <legend>Personalización</legend>
                <div class="form-group">
                    <label for="titulo_pagina">Título de la Página</label>
                    <input type="text" name="titulo_pagina" id="titulo_pagina" class="form-control"
                        value="<?php echo $info->titulo_pagina; ?>">
                </div>
                <div class="form-group">
                    <label for="color_tema">Color del Tema</label>
                    <input type="color" name="color_tema" id="color_tema" class="form-control"
                        value="<?php echo $info->color_tema; ?>" style="height: 50px;">
                </div>
            </fieldset>

            <fieldset>
                <legend>Contenido Multimedia</legend>
                <div class="form-group">
                    <label for="video_url">URL de Video (YouTube/Vimeo)</label>
                    <input type="url" name="video_url" id="video_url" class="form-control"
                        value="<?php echo $info->video_url; ?>">
                </div>
                <div class="form-group">
                    <label for="mapa_url">URL del Mapa (Google Maps Embed)</label>
                    <input type="text" name="mapa_url" id="mapa_url" class="form-control"
                        value="<?php echo $info->mapa_url; ?>">
                </div>
            </fieldset>

            <fieldset>
                <legend>Información Detallada</legend>
                <div class="form-group">
                    <label for="descripcion_extendida">Descripción Extendida</label>
                    <textarea name="descripcion_extendida" id="descripcion_extendida" class="form-control"
                        rows="5"><?php echo $info->descripcion_extendida; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="horarios_texto">Horarios de Atención</label>
                    <textarea name="horarios_texto" id="horarios_texto" class="form-control"
                        rows="3"><?php echo $info->horarios_texto; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="direccion_completa">Dirección Completa</label>
                    <textarea name="direccion_completa" id="direccion_completa" class="form-control"
                        rows="2"><?php echo $info->direccion_completa; ?></textarea>
                </div>
            </fieldset>

            <fieldset>
                <legend>Redes Sociales</legend>
                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input type="url" name="facebook" id="facebook" class="form-control"
                        value="<?php echo $info->facebook; ?>">
                </div>
                <div class="form-group">
                    <label for="instagram">Instagram</label>
                    <input type="url" name="instagram" id="instagram" class="form-control"
                        value="<?php echo $info->instagram; ?>">
                </div>
                <div class="form-group">
                    <label for="twitter">Twitter</label>
                    <input type="url" name="twitter" id="twitter" class="form-control"
                        value="<?php echo $info->twitter; ?>">
                </div>
                <div class="form-group">
                    <label for="linkedin">LinkedIn</label>
                    <input type="url" name="linkedin" id="linkedin" class="form-control"
                        value="<?php echo $info->linkedin; ?>">
                </div>
            </fieldset>

            <button type="submit" class="btn btn-primary btn-block mt-3">Guardar Cambios</button>
        </form>
    </div>
</div>