<div class="container">
    <a href="<?php echo URL_ROOT; ?>/admin/medicos" class="btn btn-light mt-2">
        < Volver</a>

            <div class="card mt-2">
                <h2>Editar Médico: <?php echo $data['medico']->nombre; ?></h2>

                <?php if (isset($data['errores'])): ?>
                    <?php foreach ($data['errores'] as $tipo => $mensajes): ?>
                        <?php foreach ($mensajes as $mensaje): ?>
                            <div class="alert alert-danger"><?php echo $mensaje; ?></div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <form action="<?php echo URL_ROOT; ?>/admin/medicos/editar/<?php echo $data['medico']->id_medico; ?>"
                    method="POST" enctype="multipart/form-data">
                    <div class="grid-3">
                        <!-- Datos Personales -->
                        <div class="form-group">
                            <label>Nombre: *</label>
                            <input type="text" name="nombre" class="form-control"
                                value="<?php echo $data['medico']->nombre; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Apellido: *</label>
                            <input type="text" name="apellido" class="form-control"
                                value="<?php echo $data['medico']->apellido; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email: *</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo $data['medico']->email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña (Dejar en blanco para no cambiar):</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Teléfono: *</label>
                            <input type="text" name="telefono" class="form-control"
                                value="<?php echo $data['medico']->telefono; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>WhatsApp: *</label>
                            <input type="text" name="whatsapp" class="form-control"
                                value="<?php echo $data['medico']->whatsapp; ?>" required>
                        </div>
                    </div>

                    <div class="grid-3">
                        <!-- Info Profesional -->
                        <div class="form-group">
                            <label>Especialidad: *</label>
                            <input type="text" name="especialidad" class="form-control"
                                value="<?php echo $data['medico']->especialidad; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Cédula Profesional:</label>
                            <input type="text" name="cedula_profesional" class="form-control"
                                value="<?php echo $data['medico']->cedula_profesional; ?>">
                        </div>
                        <div class="form-group">
                            <label>Ciudad:</label>
                            <input type="text" name="ciudad" class="form-control"
                                value="<?php echo $data['medico']->ciudad; ?>">
                        </div>
                        <div class="form-group">
                            <label>Estado:</label>
                            <input type="text" name="estado" class="form-control"
                                value="<?php echo $data['medico']->estado; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Servicios:</label>
                        <textarea name="servicios" class="form-control"
                            rows="3"><?php echo $data['medico']->servicios; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Biografía:</label>
                        <textarea name="biografia" class="form-control"
                            rows="3"><?php echo $data['medico']->biografia; ?></textarea>
                    </div>

                    <div class="grid-3">
                        <div class="form-group">
                            <label>Foto de Perfil (Dejar en blanco para mantener actual):</label>
                            <?php if ($data['medico']->foto_perfil): ?>
                                <div class="mb-2">
                                    <img src="<?php echo URL_ROOT . '/uploads/' . $data['medico']->foto_perfil; ?>"
                                        style="width: 100px; border-radius: 5px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="foto_perfil" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Plan:</label>
                            <select name="plan" class="form-control">
                                <option value="basico" <?php echo $data['medico']->plan == 'basico' ? 'selected' : ''; ?>>
                                    Básico</option>
                                <option value="premium" <?php echo $data['medico']->plan == 'premium' ? 'selected' : ''; ?>>Premium</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Vencimiento Plan:</label>
                            <input type="date" name="fecha_vencimiento_plan" class="form-control"
                                value="<?php echo $data['medico']->fecha_vencimiento_plan; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="activo" <?php echo $data['medico']->activo ? 'checked' : ''; ?>> Activo
                        </label>
                        <label style="margin-left: 20px;">
                            <input type="checkbox" name="destacado" <?php echo $data['medico']->destacado ? 'checked' : ''; ?>> Destacado
                        </label>
                    </div>

                    <input type="submit" value="Actualizar Médico" class="btn btn-primary btn-block">
                </form>
            </div>
</div>