<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médicos Oaxaca</title>
    <link rel="stylesheet" href="/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="/" class="logo">Médicos Oaxaca</a>
            <ul>
                <li><a href="/">Inicio</a></li>
                <li><a href="/directorio">Directorio</a></li>
                <?php if (isset($_SESSION['login']) && $_SESSION['login']): ?>
                    <li><a href="/admin/dashboard">Admin</a></li>
                    <li><a href="/admin/logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="/admin">Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php echo $contenido; ?>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Médicos Oaxaca. Todos los derechos reservados. | <a href="/medicos/login"
                    style="color: #666;">Soy Médico</a></p>
        </div>
    </footer>
</body>

</html>