<?php
require_once 'includes/header.php';
require_once 'includes/funciones.php';

// Obtenemos solo las últimas 3 noticias usando nuestra nueva función
$ultimasNoticias = obtenerUltimasNoticias(3);
?>

<!-- Sección Hero (Portada institucional) -->
<section class="hero-principal">
    <div class="contenedor hero-contenido">
        <h1>Bienvenidos al Portal Institucional</h1>
        <p>Innovación, transparencia y servicio para nuestra comunidad.</p>
        <a href="nosotros.php" class="btn-primario">Conoce más sobre nosotros</a>
    </div>
</section>

<!-- Sección dinámica de noticias recientes -->
<section class="seccion-inicio-noticias">
    <div class="encabezado-seccion">
        <h2>Últimas Noticias</h2>
        <!-- Enlace para ir a ver el listado completo -->
        <a href="noticias.php" class="enlace-ver-mas">Ver todas &rarr;</a>
    </div>

    <!-- Reutilizamos la misma clase grid-noticias que ya hicimos en CSS -->
    <div class="grid-noticias">
        <?php if (!empty($ultimasNoticias)): ?>
            <?php foreach ($ultimasNoticias as $noticia): ?>
                <!-- Reutilizamos la estructura de la tarjeta -->
                <article class="tarjeta-noticia">
                    <img src="uploads/noticias/<?php echo $noticia['imagen']; ?>" alt="<?php echo $noticia['titulo']; ?>">

                    <div class="tarjeta-contenido">
                        <span class="fecha"><?php echo $noticia['fecha']; ?></span>
                        <h3><?php echo $noticia['titulo']; ?></h3>
                        <p><?php echo $noticia['resumen']; ?></p>
                        <a href="noticia.php?id=<?php echo $noticia['id']; ?>" class="btn-leer">Leer más</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay noticias recientes por el momento.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>