<div class="container">
    <div class="card" style="max-width: 500px; margin: 50px auto;">
        <h2>Admin Login</h2>
        <p>Ingrese sus credenciales para acceder al panel.</p>

        <form action="<?php echo URL_ROOT; ?>/admin/login" method="POST">
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email"
                    class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Contraseña: <sup>*</sup></label>
                <input type="password" name="password"
                    class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $data['password']; ?>">
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>

            <div class="row">
                <div class="col">
                    <input type="submit" value="Ingresar" class="btn btn-block">
                </div>
            </div>
        </form>
    </div>
</div>