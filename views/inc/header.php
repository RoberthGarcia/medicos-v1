<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo URL_ROOT; ?>" class="logo"><?php echo SITE_NAME; ?></a>
            <ul>
                <li><a href="<?php echo URL_ROOT; ?>">Inicio</a></li>
                <li><a href="<?php echo URL_ROOT; ?>/medicos">Médicos</a></li>
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <li><a href="<?php echo URL_ROOT; ?>/admin">Admin</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/admin/logout">Salir</a></li>
                <?php else: ?>
                    <li><a href="<?php echo URL_ROOT; ?>/admin/login">Acceso Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>