<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de administración de publicaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body class="login">

    <form action="login.php" method="post" class="login__form">

        <i class="bi bi-person-circle"></i>
        <div class="mb-3">
            <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese usuario">
        </div>

        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña">
        </div>

         
        <?php if (isset($_GET['error'])) { ?>

            <div class="alert alert-primary" role="alert"><?php echo $_GET['error']; ?> </div>

        <?php } ?>

        <div class="d-grid gap-2">
            <input type="submit" value="Iniciar Sesión" class="btn-ingresar">
        </div>

        <small class="back"><a href="../index.php"><i class="bi bi-arrow-left-short"></i> Ir a las publicaciones</a></small>

    </form>
    
</body>

</html>