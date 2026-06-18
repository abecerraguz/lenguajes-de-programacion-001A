<?php
/**
 * config.php — Configuración de conexión a la base de datos.
 *
 * ¡IMPORTANTE! Este archivo contiene credenciales.
 * - Está excluido de Git (.gitignore) para no exponerlas en el repositorio.
 * - El acceso HTTP directo está bloqueado por class/.htaccess.
 *
 * Para configurar el proyecto por primera vez:
 *   cp class/config.example.php class/config.php
 * y edita los valores con tus datos de conexión.
 */

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Ab193842';
$dbname = 'blog';

/*

Usuario contraseña (para escribir al login)
admin	admin
editor	editor

*/
