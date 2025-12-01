<div class="container mt-3">
    <div class="card" style="max-width: 400px; margin: 0 auto;">
        <h2 class="text-center">Acceso Médicos</h2>

        <?php
        $mensajes = $errores['error'] ?? [];
        foreach ($mensajes as $error):
            ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endforeach; ?>

        <form method="POST" action="/medicos/login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </form>
    </div>
</div>