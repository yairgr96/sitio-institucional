<?php
// 1. Configuramos nuestra contraseña de seguridad y variables de mensajes
$password_secreta = "admin123";
$mensaje = "";
$clase_mensaje = "";

// Requerimos nuestras funciones para poder leer el JSON actual
require_once 'includes/funciones.php';

// 2. Verificamos si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificamos la contraseña primero
    if ($_POST['clave'] !== $password_secreta) {
        $mensaje = "Clave de autorización incorrecta. No tienes permiso para publicar.";
        $clase_mensaje = "error";
    } else {
        // 3. Procesamos la imagen subida ($_FILES)
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temporal = $_FILES['imagen']['tmp_name']; // Donde el servidor la guarda temporalmente

        // Creamos un nombre único usando la marca de tiempo actual (timestamp)
        $nombre_final_imagen = time() . "_" . basename($imagen_nombre);
        $ruta_destino = __DIR__ . '/uploads/noticias/' . $nombre_final_imagen;

        // Movemos el archivo de la memoria temporal a nuestra carpeta definitiva
        if (move_uploaded_file($imagen_temporal, $ruta_destino)) {

            // 4. Preparamos los datos
            $noticias_actuales = obtenerNoticias();

            // Calculamos el nuevo ID (buscamos el ID más alto y le sumamos 1)
            $nuevo_id = 1;
            foreach ($noticias_actuales as $n) {
                if ($n['id'] >= $nuevo_id) {
                    $nuevo_id = $n['id'] + 1;
                }
            }

            // Construimos el nuevo elemento del arreglo
            $nueva_noticia = [
                "id" => $nuevo_id,
                "titulo" => htmlspecialchars($_POST['titulo']),
                "fecha" => $_POST['fecha'],
                "imagen" => $nombre_final_imagen, // Guardamos solo el nombre único
                "resumen" => htmlspecialchars($_POST['resumen']),
                "contenido" => $_POST['contenido'], // Permitimos HTML para negritas, saltos, etc.
                "video" => htmlspecialchars($_POST['video'])
            ];

            // 5. Agregamos la nueva noticia al arreglo existente
            $noticias_actuales[] = $nueva_noticia;

            // 6. Codificamos de vuelta a JSON y guardamos en el archivo
            $ruta_json = __DIR__ . '/data/noticias.json';

            // JSON_PRETTY_PRINT hace que el archivo siga siendo legible si lo abres en VS Code
            if (file_put_contents($ruta_json, json_encode($noticias_actuales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                $mensaje = "¡Noticia publicada exitosamente!";
                $clase_mensaje = "exito";
            } else {
                $mensaje = "Error al guardar los datos en el archivo JSON.";
                $clase_mensaje = "error";
            }
        } else {
            $mensaje = "Hubo un error al subir la imagen al servidor.";
            $clase_mensaje = "error";
        }
    }
}

require_once 'includes/header.php';
?>

<section class="contenedor principal" style="max-width: 800px; margin: 0 auto;">
    <h1 style="margin-bottom: 10px;">Panel de Publicación</h1>
    <p style="margin-bottom: 30px; color: #666;">Sube un nuevo comunicado oficial al sistema.</p>

    <!-- Bloque para mostrar el mensaje de éxito o error -->
    <?php if ($mensaje != ''): ?>
        <div style="padding: 15px; margin-bottom: 20px; border-radius: 4px; font-weight: bold; 
                 background-color: <?php echo ($clase_mensaje == 'exito') ? '#d4edda' : '#f8d7da'; ?>;
                 color: <?php echo ($clase_mensaje == 'exito') ? '#155724' : '#721c24'; ?>;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="grid-contacto" style="display: block;">
        <div class="formulario-contacto">
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="grupo-form">
                    <label for="clave">Clave de autorización:</label>
                    <input type="password" id="clave" name="clave" placeholder="Ingresa la contraseña para publicar" required>
                </div>

                <div class="grupo-form">
                    <label for="titulo">Título de la noticia:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>

                <div class="grupo-form">
                    <label for="fecha">Fecha del comunicado:</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>

                <div class="grupo-form">
                    <label for="imagen">Imagen principal (Formato JPG o PNG):</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>

                <div class="grupo-form">
                    <label for="resumen">Resumen corto (Aparecerá en la tarjeta de la página principal):</label>
                    <textarea id="resumen" name="resumen" rows="2" required></textarea>
                </div>

                <div class="grupo-form">
                    <label for="contenido">Contenido completo (Puedes usar HTML como &lt;p&gt;, &lt;b&gt;):</label>
                    <!-- Dejamos un texto de ejemplo precargado para facilitar la captura -->
                    <textarea id="contenido" name="contenido" rows="8" required><p>Escribe tu primer párrafo aquí.</p><p>Escribe el segundo párrafo aquí.</p></textarea>
                </div>

                <div class="grupo-form">
                    <label for="video">Enlace del video de YouTube (Opcional):</label>
                    <input type="text" id="video" name="video" placeholder="Ej: https://www.youtube.com/embed/ejemplo">
                </div>

                <button type="submit" class="btn-primario" style="width: 100%;">Subir y Publicar Noticia</button>
            </form>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>