<?php
    session_start();
    // Destruye todas las variables de sesión
    session_destroy();

    // Redirecciona al formulario de inicio de sesión
    header("Location: index.php?error=Sesión cerrada !");
    exit();
?>
