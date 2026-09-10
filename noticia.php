<?php
require_once 'includes/header.php';
require_once 'includes/funciones.php';

// Capturamos el parámetro 'id' de la URL (igual que los query params en Postman)
// Usamos isset() para evitar errores si alguien entra sin poner un ID
$id_buscado = isset($_GET['id']) ? $_GET['id'] : null;

// Buscamos la noticia
$noticia = null;
if ($id_buscado) {
    $noticia = obtenerNoticiaPorId($id_buscado);
}
?>

<section class="seccion-articulo">
    <?php if ($noticia): // Si encontramos la noticia, mostramos el artículo 
    ?>
        <article class="articulo-completo">
            <h1><?php echo $noticia['titulo']; ?></h1>
            <span class="fecha"><?php echo $noticia['fecha']; ?></span>

            <img src="uploads/noticias/<?php echo $noticia['imagen']; ?>" alt="<?php echo $noticia['titulo']; ?>" class="img-articulo">

            <div class="contenido-html">
                <!-- Aquí se imprimen los párrafos <p> que guardamos en el JSON -->
                <?php echo $noticia['contenido']; ?>
            </div>

            <!-- Si la noticia tiene un video de YouTube, mostramos el iframe -->
            <?php if (!empty($noticia['video'])): ?>
                <div class="contenedor-video">
                    <iframe src="<?php echo $noticia['video']; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            <?php endif; ?>

            <a href="noticias.php" class="btn-volver">&larr; Volver a noticias</a>
        </article>

    <?php else: // Si no se encontró (ej. pusieron id=999 en la URL) 
    ?>
        <div class="mensaje-error">
            <h2>Noticia no encontrada</h2>
            <p>Lo sentimos, el comunicado que buscas no existe.</p>
            <a href="noticias.php" class="btn-volver">&larr; Volver a noticias</a>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>