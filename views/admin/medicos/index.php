<div class="container">
    <div class="row" style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div class="col">
            <h1>Gestionar Médicos</h1>
            <?php include_once __DIR__ . '/../../inc/alertas.php'; ?>
        </div>
        <div class="col">
            <a href="<?php echo URL_ROOT; ?>/admin/medicos/crear" class="btn btn-secondary">
                <i class="fa fa-plus"></i> Nuevo Médico
            </a>
        </div>
    </div>

    <div class="card mt-2">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Plan</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['medicos'] as $medico): ?>
                        <tr>
                            <td>
                                <?php if ($medico->foto_perfil): ?>
                                    <img src="<?php echo URL_ROOT . '/uploads/' . $medico->foto_perfil; ?>" alt="Foto"
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <span>Sin foto</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $medico->nombre . ' ' . $medico->apellido; ?></td>
                            <td><?php echo $medico->especialidad; ?></td>
                            <td>
                                <span
                                    class="badge <?php echo $medico->plan === 'premium' ? 'badge-premium' : 'badge-success'; ?>">
                                    <?php echo ucfirst($medico->plan); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo $medico->activo ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $medico->activo ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo URL_ROOT; ?>/admin/medicos/editar/<?php echo $medico->id_medico; ?>"
                                    class="btn btn-primary btn-sm" title="Editar médico">
                                    <i class="fa fa-edit"></i> Editar
                                </a>

                                <!-- Botón Toggle (Activar/Desactivar) -->
                                <form action="<?php echo URL_ROOT; ?>/admin/medicos/toggle" method="POST"
                                    style="display: inline;">
                                    <input type="hidden" name="id_medico" value="<?php echo $medico->id_medico; ?>">
                                    <button type="submit"
                                        class="btn <?php echo $medico->activo ? 'btn-warning' : 'btn-success'; ?> btn-sm btn-toggle-medico"
                                        data-nombre="<?php echo $medico->nombre . ' ' . $medico->apellido; ?>"
                                        data-accion="<?php echo $medico->activo ? 'desactivar' : 'activar'; ?>"
                                        title="<?php echo $medico->activo ? 'Desactivar' : 'Activar'; ?> médico">
                                        <i class="fa fa-<?php echo $medico->activo ? 'eye-slash' : 'eye'; ?>"></i>
                                        <?php echo $medico->activo ? 'Desactivar' : 'Activar'; ?>
                                    </button>
                                </form>

                                <!-- Botón Eliminar -->
                                <form action="<?php echo URL_ROOT; ?>/admin/medicos/eliminar" method="POST"
                                    style="display: inline;">
                                    <input type="hidden" name="id_medico" value="<?php echo $medico->id_medico; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete-medico"
                                        data-nombre="<?php echo $medico->nombre . ' ' . $medico->apellido; ?>"
                                        title="Eliminar médico">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?php echo URL_ROOT; ?>/js/admin.js"></script>