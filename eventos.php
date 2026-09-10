<?php
require_once 'includes/header.php';
require_once 'includes/funciones.php';

$todosLosEventos = obtenerEventos();
?>

<section class="seccion-eventos">
    <div class="encabezado-eventos">
        <h1>Próximos Eventos</h1>
        <p>Consulta la agenda de actividades institucionales.</p>
    </div>

    <div class="lista-eventos">
        <?php if (!empty($todosLosEventos)): ?>
            <?php foreach ($todosLosEventos as $evento): ?>
                <div class="tarjeta-evento">
                    <div class="evento-fecha">
                        <!-- Mostramos solo el día y mes si quisiéramos, por ahora la fecha completa -->
                        <span><?php echo $evento['fecha']; ?></span>
                    </div>
                    <div class="evento-detalles">
                        <h3><?php echo $evento['titulo']; ?></h3>
                        <p class="evento-lugar"><strong>Lugar:</strong> <?php echo $evento['lugar']; ?></p>
                        <p><?php echo $evento['descripcion']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay eventos programados en este momento.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>