
<?php
    include_once '../class/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platilla de Blog</title>
    <!-- Javascript Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Importamos CSS de Datatable -->
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.5/datatables.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrlfront) ?>/assets/css/main.css?version=<?php echo time();?>">
</head>

<body>
    <!-- Inicio del header -->
    <header>
        <nav class="navbar">
            <div class="container containerNavAdmin">

                <a class="navbar-brand text-uppercase" href="<?= htmlspecialchars($baseUrlAdmin) ?>/admin_list.php">
                    <img src="<?= htmlspecialchars($baseUrlfront) ?>/assets/img/blog.png" alt="" width="50">
                    <span> Publicaciones </span>
                </a>

                <ul class="lista">
                    <li>
                         <a class="navbar__registrarse" href="admin-usuarios.php">administrador de usuarios</a>
                    </li>
                    <li>
                         <a class="navbar__registrarse" href="admin.php">administrador de publicaciones</a>
                    </li>
                    <li>
                         <a class="navbar__registrarse" href="logout.php">Cerrar Sesión <i class="bi bi-box-arrow-right"></i> </a>
                    </li>
                </ul>

                

            </div>
        </nav>
    </header>
    <!-- Cierre del header -->