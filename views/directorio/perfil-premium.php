<style>
    :root {
        --medico-color:
            <?php echo $medico->color_tema ?? '#0066CC'; ?>
        ;
    }

    .premium-header {
        background: linear-gradient(135deg, var(--medico-color), #000);
        color: #fff;
        padding: 40px 0;
        border-radius: 0 0 20px 20px;
        margin-bottom: 30px;
    }

    .btn-medico {
        background-color: var(--medico-color);
        color: #fff;
    }

    .btn-medico:hover {
        opacity: 0.9;
        color: #fff;
    }
</style>

<div class="premium-header text-center">
    <div class="container">
        <?php if ($medico->foto_perfil): ?>
            <img src="<?php echo URL_ROOT . '/uploads/' . $medico->foto_perfil; ?>" alt="Foto"
                style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 4px solid #fff; margin: 0 auto;">
        <?php endif; ?>
        <h1 class="mt-1">Dr. <?php echo $medico->nombre . ' ' . $medico->apellido; ?></h1>
        <h3><?php echo $medico->especialidad; ?></h3>
        <p><i class="fa fa-map-marker"></i> <?php echo $medico->ciudad . ', ' . $medico->estado; ?></p>
    </div>
</div>

<div class="container">
    <div class="grid-3" style="grid-template-columns: 2fr 1fr;">
        <div>
            <div class="card">
                <h2>Sobre Mí</h2>
                <p><?php echo nl2br($medico->biografia); ?></p>

                <h3 class="mt-2">Servicios</h3>
                <p><?php echo nl2br($medico->servicios); ?></p>
            </div>

            <!-- Gallery Placeholder -->
            <div class="card mt-2">
                <h3>Galería</h3>
                <p><em>Galería de imágenes disponible próximamente.</em></p>
            </div>
        </div>

        <div>
            <div class="card">
                <h3>Contacto</h3>
                <?php
                $whatsapp = preg_replace('/[^0-9]/', '', $medico->whatsapp);
                $mensaje = urlencode("Hola Dr. " . $medico->nombre . ", vi tu perfil en Médicos Oaxaca y me gustaría agendar una consulta.");
                $link = "https://wa.me/52{$whatsapp}?text={$mensaje}";
                ?>
                <a href="<?php echo $link; ?>" target="_blank" class="btn btn-whatsapp btn-block" style="background-color: #25D366 !important; color: #fff !important;">
                    <i class="fa-brands fa-whatsapp"></i> Agendar por WhatsApp
                </a>
                <a href="tel:<?php echo $medico->telefono; ?>" class="btn btn-medico btn-block mt-1">
                    Llamar: <?php echo $medico->telefono; ?>
                </a>

                <hr class="mt-2 mb-2">

                <p><strong>Email:</strong> <?php echo $medico->email; ?></p>
                <p><strong>Cédula:</strong> <?php echo $medico->cedula_profesional; ?></p>
            </div>

            <div class="card mt-2">
                <h3>Ubicación</h3>
                <!-- Map Placeholder -->
                <div
                    style="background: #eee; height: 200px; display: flex; align-items: center; justify-content: center;">
                    Mapa de Ubicación
                </div>
                <p class="mt-1"><?php echo $medico->ciudad; ?></p>
            </div>
        </div>
    </div>
</div>