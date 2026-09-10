<?php
require_once 'includes/header.php';
require_once 'includes/funciones.php';

$todasLasNoticias = obtenerNoticias();
?>

<section class="seccion-noticias">
    <h1>Noticias y Comunicados</h1>
    <p class="descripcion-seccion">Mantente informado sobre las últimas novedades de nuestra institución.</p>

    <div class="grid-noticias">
        <?php
        // Verificamos si hay noticias para mostrar
        if (!empty($todasLasNoticias)) {
            // Iniciamos el ciclo: por cada elemento, lo llamaremos temporalmente $noticia
            foreach ($todasLasNoticias as $noticia):
        ?>
                <!-- Tarjeta individual -->
                <article class="tarjeta-noticia">
                    <!-- Mostramos la imagen (Nota: se verá rota hasta que pongamos imágenes reales en la carpeta) -->
                    <img src="uploads/noticias/<?php echo $noticia['imagen']; ?>" alt="<?php echo $noticia['titulo']; ?>">

                    <div class="tarjeta-contenido">
                        <span class="fecha"><?php echo $noticia['fecha']; ?></span>
                        <h3><?php echo $noticia['titulo']; ?></h3>
                        <p><?php echo $noticia['resumen']; ?></p>

                        <!-- Construimos la URL dinámica enviando el ID -->
                        <a href="noticia.php?id=<?php echo $noticia['id']; ?>" class="btn-leer">Leer más</a>
                    </div>
                </article>
        <?php
            endforeach;
        } else {
            echo "<p>No hay noticias publicadas por el momento.</p>";
        }
        ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>