<?php
/**
 * helpers.php — Funciones utilitarias compartidas por todo el CMS.
 *
 * Incluir con: include_once('class/helpers.php')        (desde raíz)
 *              include_once('../class/helpers.php')      (desde admin/)
 */

/**
 * Formatea una fecha de BD en formato corto: "3 may 2026".
 * 
 * @param string $fecha Fecha proveniente de la BD (ej: "2026-05-03 13:18:32")
 * @return string Fecha formateada sin puntos en la abreviación
 */
function formatearFechaCorta($fecha) {
    // 1. Convertimos el texto de la BD en un objeto DateTime nativo de PHP
    $date = new DateTime($fecha);
    
    // 2. Configuramos el formateador en español con estilo MEDIO (abrevia el mes)
    // El tercer parámetro (NONE) le indica que ignore las horas, minutos y segundos
    $formatter = new IntlDateFormatter(
        'es_ES', 
        IntlDateFormatter::MEDIUM, 
        IntlDateFormatter::NONE
    );
    
    // 3. PHP por defecto añade un punto al mes corto (ej: "3 may."). 
    // Usamos str_replace para quitarlo y que quede exactamente "3 may 2026"
    return str_replace('.', '', $formatter->format($date));
}

/**
 * Formatea una fecha de BD en formato largo: "3 de mayo de 2026".
 * 
 * @param string $fecha Fecha proveniente de la BD (ej: "2026-05-03 13:18:32")
 * @return string Fecha formateada con los conectores "de" automáticos
 */
function formatearFechaLarga($fecha) {
    // 1. Convertimos el texto de la BD en un objeto DateTime nativo de PHP
    $date = new DateTime($fecha);
    
    // 2. Configuramos el formateador en español con estilo LARGO
    // Este estilo añade automáticamente los conectores "de" y escribe el mes completo
    $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    
    // 3. Retornamos la fecha completamente formateada en texto
    return $formatter->format($date);
}

/**
 * Calcula los minutos estimados de lectura (200 palabras/min).
 * Versión mejorada compatible con tildes, diéresis y la letra Ñ.
 * 
 * @param string $texto El contenido que se va a evaluar (puede incluir HTML).
 * @return int La cantidad de minutos estimados (mínimo 1).
 */
function calcularLectura($texto) {
    // 1. Eliminamos las etiquetas HTML para procesar solo el texto visible.
    $texto_limpio = strip_tags($texto);
    
    // 2. Usamos una expresión regular compatible con UTF-8 (/u).
    // \p{L} busca cualquier letra de cualquier idioma (incluye á, é, í, ó, ú, ü, ñ, Ñ).
    // \p{N} incluye números por si el texto dice "en el año 2026".
    // El guion \- permite que palabras compuestas como "físico-químico" cuenten correctamente.
    preg_match_all('/[\p{L}\p{N}\-]+/u', $texto_limpio, $coincidencias);

    print_r($coincidencias[0]);
    
    // 3. Contamos cuántos elementos (palabras) se encontraron en el arreglo.
    /*

    $coincidencias = [
        0 => [
            0 => "Hola-mundo",
            1 => "2026"
        ]
    ];
    
    */
    $total_palabras = count($coincidencias[0]);

    /*
    
    Tiempo de lectura (En minutos) =      Total de palabras del texto
                                    ------------------------------------------
                                    Velocidad de lectura (Palabras por minuto)
    
    */
    
    // 4. Dividimos entre 200 palabras por minuto y redondeamos hacia arriba con ceil().
    $minutos_calculados = (int)ceil($total_palabras / 200);
    
    // 5. max(1, ...) garantiza que el resultado nunca sea 0 minutos.
    return max(1, $minutos_calculados);
}

/**
 * @param string $slug recibe una cadena de texto
 * @return string Retorna una cadena de texto
 */

function badgeClass($slug){
    // print_r($slug);
    $map = [
        'tecnologia'  => 'td-badge--tech',
        'cosplay'     => 'td-badge--cosplay',
        'series'      => 'td-badge--series',
        'videojuegos' => 'td-badge--gaming',
    ];
    return $map[$slug] ?? 'td-badge--default';
}

/**
 * Valida, sube y guarda una imagen de artículo.
 *
 * @param  array  $file     Elemento de $_FILES correspondiente a la imagen.
 * @param  string $destDir  Ruta absoluta al directorio de destino (ej: '/var/www/uploads').
 * @return string           Nombre final del archivo guardado (ej: 'a1b2c3d4e5f6.jpg').
 * @throws RuntimeException Si la validación o la copia fallan.
 */
function subirImagenArticulo($file, $destDir) {
  
    // echo "<pre>"; print_r($file); echo "</pre>"; 
    // echo "<pre>"; print_r($destDir); echo "</pre>"; 
  
    // 1. Definimos una lista limpia de los formatos de imagen que el servidor aceptará.
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/avif', 'image/gif'];
    
    // 2. Un mapa para asignarle la extensión correcta al archivo final según su tipo real.
    $extMap = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/avif' => 'avif',
        'image/gif'  => 'gif',
    ];

    // 3. Medida de seguridad clave: mime_content_type lee los primeros bytes del archivo temporal 
    // en el servidor para saber qué es realmente, ignorando si el usuario le cambió el nombre.
    // detecta que es image/jpeg
    $tipoReal = mime_content_type($file['tmp_name']);
    // echo "<pre>"; print_r($tipoReal); echo "</pre>"; 
    

    // 4. Si el tipo real del archivo no está en nuestra lista permitida, detenemos todo con un error.
    if (!in_array($tipoReal, $tiposPermitidos, true)) {
        throw new RuntimeException('Tipo de archivo no permitido.');
    }
  
    
    // 5. Validamos el tamaño. 5 * 1024 * 1024 convierte 5 Megabytes a Bytes exactos.
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('La imagen supera el tamaño máximo de 5 MB.');
    }
  
    // 6. Creamos un nombre ultra seguro: random_bytes genera 10 bytes aleatorios y bin2hex 
    // los convierte en una cadena de 20 caracteres (ej: "4a7f2c..."). Luego le añade la extensión.
    $validarRandomByte = random_bytes(10);
    $nombre  = bin2hex(random_bytes(10)) . '.' . $extMap[$tipoReal];
    //  echo "<pre>"; print_r($validarRandomByte); echo "</pre>"; 
    //  echo "<pre>"; print_r($nombre); echo "</pre>"; 
    // die();
    // 7. rtrim elimina barras diagonales sobrantes al final de la ruta destino para evitar 
    // rutas mal armadas como "/carpeta//archivo.jpg", y luego concatena el nuevo nombre.
    $destino = rtrim($destDir, '/') . '/' . $nombre;

    // 8. move_uploaded_file mueve el archivo desde la carpeta temporal de PHP al destino final.
    // Además, verifica que el archivo realmente provenga de una subida HTTP válida.
    if (!move_uploaded_file($file['tmp_name'], $destino)) {
        throw new RuntimeException('No se pudo guardar la imagen. Verifica los permisos.');
    }

    // 9. Retornamos solo el nombre del archivo generado para que puedas guardarlo en tu Base de Datos.
    return $nombre;
}
