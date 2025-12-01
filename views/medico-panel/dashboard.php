<div class="container mt-3">
    <h1>Panel del Médico</h1>
    <div class="card">
        <h2>Bienvenido, Dr. <?php echo $nombre; ?></h2>
        <p>Desde aquí puedes gestionar tu perfil y servicios.</p>

        <div class="grid-3 mt-2">
            <div class="card text-center">
                <h3>Mi Perfil</h3>
                <p>Editar información personal y profesional.</p>
                <a href="/medicos/perfil/editar" class="btn btn-primary btn-block">Editar Perfil</a>
            </div>

            <?php if (isset($_SESSION['medico_plan']) && $_SESSION['medico_plan'] === 'premium'): ?>
                <div class="card text-center" style="border: 2px solid gold;">
                    <h3>Galería Premium</h3>
                    <p>Gestionar fotos de la galería.</p>
                    <a href="/medicos/galeria" class="btn btn-warning btn-block">Gestionar Galería</a>
                </div>
                <div class="card text-center" style="border: 2px solid gold;">
                    <h3>Info Premium</h3>
                    <p>Horarios, mapa, redes sociales.</p>
                    <a href="/medicos/info-premium" class="btn btn-warning btn-block">Editar Info</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>