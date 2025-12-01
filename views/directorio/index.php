<div class="hero">
    <div class="container">
        <h1>Encuentra tu especialista en Oaxaca</h1>
        <p>Directorio médico profesional de confianza</p>

        <form action="<?php echo URL_ROOT; ?>/medicos/buscar" method="GET" class="search-form">
            <div class="form-group">
                <input type="text" name="q" class="form-control"
                    placeholder="Buscar por nombre, especialidad o ciudad...">
            </div>
            <button type="submit" class="btn btn-secondary">Buscar</button>
        </form>
    </div>
</div>

<div class="container mt-5">
    <h2>Médicos Destacados</h2>
    <div class="grid-3">
        <?php foreach ($medicos as $medico): ?>
            <div class="card">
                <h3><?php echo $medico->nombre . ' ' . $medico->apellido; ?></h3>
                <p><strong><?php echo $medico->especialidad; ?></strong></p>
                <p><?php echo $medico->ciudad; ?></p>
                <a href="<?php echo URL_ROOT; ?>/medicos/perfil/<?php echo $medico->id_medico; ?>"
                    class="btn btn-primary btn-block">Ver
                    Perfil</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>