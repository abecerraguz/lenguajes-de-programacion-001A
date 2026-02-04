<?php

declare(strict_types=1);

/**
 * Config DB (con soporte para variables de entorno).
 * Si no existen, usa valores por defecto (local).
 */
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'cms_deportes');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

/**
 * Base URL por si tu proyecto está en subcarpeta.
 * Ej: '/cms' o '' si está en la raíz del dominio.
 */
define('APP_BASE_URL', getenv('APP_BASE_URL') ?: '');

/**
 * Imagen por defecto (tu BD no tiene campo de imagen en cms_articulos).
 */
define('APP_PLACEHOLDER_IMG', 'assets/img/blog.png');
