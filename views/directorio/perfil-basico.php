<div class="container mt-3">
    <div class="card">
        <div class="grid-3" style="grid-template-columns: 1fr 2fr;">
            <div class="text-center">
                <?php if ($medico->foto_perfil): ?>
                    <img src="<?php echo URL_ROOT . '/uploads/' . $medico->foto_perfil; ?>" alt="Foto"
                        style="width: 100%; border-radius: 10px; max-width: 300px; margin: 0 auto;">
                <?php else: ?>
                    <img src="https://via.placeholder.com/300" alt="Foto" style="width: 100%; border-radius: 10px;">
                <?php endif; ?>
            </div>
            <div>
                <h1>Dr. <?php echo $medico->nombre . ' ' . $medico->apellido; ?></h1>
                <h3 class="text-primary"><?php echo $medico->especialidad; ?></h3>
                <p class="mt-1"><strong>Cédula:</strong> <?php echo $medico->cedula_profesional; ?></p>
                <p><strong>Ubicación:</strong> <?php echo $medico->ciudad . ', ' . $medico->estado; ?>
                </p>

                <div class="mt-2">
                    <h4>Biografía</h4>
                    <p><?php echo nl2br($medico->biografia); ?></p>
                </div>

                <div class="mt-2">
                    <h4>Servicios</h4>
                    <p><?php echo nl2br($medico->servicios); ?></p>
                </div>

                <div class="mt-2">
                    <?php
                    $whatsapp = preg_replace('/[^0-9]/', '', $medico->whatsapp);
                    $mensaje = urlencode("Hola Dr. " . $medico->nombre . ", vi tu perfil en Médicos Oaxaca y me gustaría agendar una consulta.");
                    $link = "https://wa.me/52{$whatsapp}?text={$mensaje}";
                    ?>
                    <a href="<?php echo $link; ?>" target="_blank" class="btn btn-whatsapp btn-block" style="background-color: #25D366 !important; color: #fff !important;">
                        <i class="fa-brands fa-whatsapp"></i> Contactar por WhatsApp
                    </a>
                    <a href="tel:<?php echo $medico->telefono; ?>" class="btn btn-primary btn-block mt-1">
                        Llamar: <?php echo $medico->telefono; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>