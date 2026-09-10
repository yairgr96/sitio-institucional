<?php
// Función para leer y decodificar el archivo JSON de noticias
function obtenerNoticias()
{
    // 1. Definimos la ruta absoluta del archivo para evitar errores de directorios
    $rutaArchivo = __DIR__ . '/../data/noticias.json';

    // 2. Verificamos si el archivo existe por seguridad
    if (!file_exists($rutaArchivo)) {
        return []; // Si no existe, devolvemos un arreglo vacío para no romper el sitio
    }

    // 3. Leemos el contenido del archivo como texto plano
    $contenidoJson = file_get_contents($rutaArchivo);

    // 4. Convertimos el texto JSON a un arreglo asociativo de PHP (el parámetro 'true' es obligatorio para esto)
    $noticias = json_decode($contenidoJson, true);

    return $noticias;
}

// Función para buscar una noticia específica por su ID
function obtenerNoticiaPorId($id)
{
    $noticias = obtenerNoticias(); // Reutilizamos la función anterior

    foreach ($noticias as $noticia) {
        // Si el ID de la noticia actual coincide con el que buscamos, la devolvemos
        if ($noticia['id'] == $id) {
            return $noticia;
        }
    }
    // Si termina el ciclo y no encuentra nada, devolvemos null
    return null;
}

// Función para obtener solo las noticias más recientes para la página de inicio
function obtenerUltimasNoticias($cantidad = 3)
{
    $noticias = obtenerNoticias(); // Traemos todas

    // Invertimos el arreglo asumiendo que las noticias más nuevas se agregan al final del JSON
    $noticias_invertidas = array_reverse($noticias);

    // Cortamos el arreglo para devolver únicamente el número de noticias que pedimos
    return array_slice($noticias_invertidas, 0, $cantidad);
}

// Función para leer el archivo de eventos
function obtenerEventos()
{
    $rutaArchivo = __DIR__ . '/../data/eventos.json';

    if (!file_exists($rutaArchivo)) {
        return [];
    }

    $contenidoJson = file_get_contents($rutaArchivo);
    return json_decode($contenidoJson, true);
}
