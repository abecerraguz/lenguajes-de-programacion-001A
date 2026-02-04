    <?php
        include_once('includes/controlSesion.php');
        include_once('includes/header.php');
        include_once('../class/config.php');
        include_once('../class/db.php');
        include_once('admin_eliminar.php');

        $conn = new db( $host, $username, $password, $dbaname );
        $articulos = $conn->query('SELECT * FROM posts INNER JOIN users ON posts.author_id = users.user_id')->fetchAll();
    ?>
    <!-- Cierre del header -->
    <main class="container">

        <h1>Administrador de publicaciones</h1>

        <div class="row">
            <div
                class="col-12 d-flex justify-content-between align-items-center mt-5 mb-3 border-bottom border-dark-subtle">
                <div class="d-flex justify-content-between align-items-center info__user"><i
                        class="bi bi-arrow-right-circle"></i><span>Bienvenido, <?php echo $_SESSION["username"];?></span></div>
                <a href="admin_insertar.php" class="btn-secondary"><i class="bi bi-plus-circle me-2"></i>Nueva publicación</a>
                <!-- <a href="#" class="btn-secondary" data-bs-toggle="modal" data-bs-target="#nuevaPublicacion"><i class="bi bi-plus-circle me-2"></i>Nueva publicación</a> -->

    
            </div>
            <?php if (isset($_GET['info'])) { ?>
                <div id="info" class="alert alert-primary" role="alert"><?php echo $_GET['info']; ?> </div>
            <?php } ?>
        </div>
        <div class="wrapperTable">
            <table class="">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Autor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  

                <?php
                      

                        function parImpar($numero){
                            return $numero % 2 == 0 ? ' class="par"' : ' class="impar"';
                        }

                        foreach ( $articulos as $indice => $articulo ) {
                            $num = $indice+1;
                            echo "<tr ".parImpar($indice).">";
                            echo "<td>$num</td>
                           <td>{$articulo['title']}</td>
                           <td>{$articulo['publish_date']}</td>
                           <td>{$articulo['full_name']}</td>
                        <td>
                            <div class='buttonAction'>
                                <a href='admin_editar.php?id={$articulo['post_id']}' class='btn-edit'><i class='bi bi-pencil-square me-1'></i>Editar</a>
                                <a href='#' class='btn-delete' data-bs-toggle='modal' data-bs-target='#eliminarPublicacion-{$articulo['post_id']}'><i class='bi bi-x-circle me-1'></i>Eliminar</a>
                            </div>
                        </td>";
                            echo delete_article( $articulo['post_id'], $articulo['title']  );
                        }
                        $conn->close();

                ?>
<?php include_once('includes/footer.php');?>