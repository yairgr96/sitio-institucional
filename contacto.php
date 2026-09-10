<?php
// 1. Inicializamos variables para los mensajes
$mensaje_estado = '';
$clase_estado = '';

// 2. Verificamos si el formulario fue enviado (Método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Sanitización básica (Seguridad: evitamos que inyecten scripts HTML/JS)
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    // 4. Validación: Verificamos que el email tenga un formato válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje_estado = "Por favor, ingresa un correo electrónico válido.";
        $clase_estado = "error";
    } elseif (empty($nombre) || empty($mensaje)) {
        $mensaje_estado = "Todos los campos son obligatorios.";
        $clase_estado = "error";
    } else {
        // 5. Preparación para el envío de correo (Funcionará en el hosting real)
        $destinatario = "contacto@tuinstitucion.mx"; // Cambiarás esto por el correo del cliente
        $asunto = "Nuevo mensaje de contacto de: $nombre";
        $cuerpo = "Nombre: $nombre\nCorreo: $email\n\nMensaje:\n$mensaje";
        $headers = "From: webmaster@tuinstitucion.mx" . "\r\n" .
            "Reply-To: $email" . "\r\n" .
            "X-Mailer: PHP/" . phpversion();

        // En un servidor local (XAMPP) la función mail() suele fallar si no se configura un SMTP.
        // Simularemos el éxito para poder avanzar, pero este código es el real para producción.
        /* 
        if(mail($destinatario, $asunto, $cuerpo, $headers)) {
            $mensaje_estado = "¡Gracias! Tu mensaje ha sido enviado correctamente.";
            $clase_estado = "exito";
        } else {
            $mensaje_estado = "Hubo un error al enviar el mensaje. Intenta más tarde.";
            $clase_estado = "error";
        }
        */

        // Simulación de éxito para entorno local:
        $mensaje_estado = "¡Gracias $nombre! Tu mensaje ha sido procesado (Simulación local).";
        $clase_estado = "exito";
    }
}

// Después de procesar la lógica, cargamos el diseño
require_once 'includes/header.php';
?>

<section class="seccion-contacto">
    <h1>Contacto</h1>
    <p class="descripcion-seccion">Estamos para atenderte. Envíanos un mensaje o comunícate directamente.</p>

    <!-- Bloque para mostrar el mensaje de éxito o error -->
    <?php if ($mensaje_estado != ''): ?>
        <!-- Aplicamos estilos en línea temporalmente para destacar el mensaje -->
        <div style="padding: 15px; margin-bottom: 20px; border-radius: 4px; font-weight: bold; 
                 background-color: <?php echo ($clase_estado == 'exito') ? '#d4edda' : '#f8d7da'; ?>;
                 color: <?php echo ($clase_estado == 'exito') ? '#155724' : '#721c24'; ?>;">
            <?php echo $mensaje_estado; ?>
        </div>
    <?php endif; ?>

    <div class="grid-contacto">
        <div class="info-contacto">
            <h3>Información Institucional</h3>
            <ul>
                <li><strong>Dirección:</strong> Av. Insurgentes Sur 1971, CDMX</li>
                <li><strong>Teléfono:</strong> (55) 1234-5678</li>
                <li><strong>Horario:</strong> Lunes a Viernes, 9:00 AM - 6:00 PM</li>
            </ul>
        </div>

        <div class="formulario-contacto">
            <!-- El action="" indica que el formulario se enviará a este mismo archivo -->
            <form action="" method="POST">
                <div class="grupo-form">
                    <label for="nombre">Nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="grupo-form">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="grupo-form">
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn-primario">Enviar mensaje</button>
            </form>
        </div>
    </div>
</section>

<a href="https://wa.me/525512345678?text=Hola,%20necesito%20información" class="whatsapp-flotante" target="_blank" rel="noopener noreferrer">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
</a>

<?php require_once 'includes/footer.php'; ?>