<div class="container">
    <div class="row" style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div class="col">
            <h1>Dashboard</h1>
        </div>
        <div class="col">
            <a href="<?php echo URL_ROOT; ?>/admin/logout" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

    <div class="card mt-2">
        <h3>Bienvenido, <?php echo $_SESSION['admin_name']; ?></h3>
        <p>Desde aquí puedes administrar el directorio de médicos.</p>

        <div class="grid-3 mt-2">
            <div class="card text-center">
                <h3>Médicos</h3>
                <p>Gestionar el directorio de médicos.</p>
                <a href="<?php echo URL_ROOT; ?>/admin/medicos" class="btn btn-primary btn-block mt-1">Ver Médicos</a>
                <a href="<?php echo URL_ROOT; ?>/admin/medicos/crear" class="btn btn-secondary btn-block mt-1">Nuevo
                    Médico</a>
            </div>
            <!-- Future modules can go here -->
        </div>
    </div>
</div>