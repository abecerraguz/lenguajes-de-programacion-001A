<?php
    include_once 'includes/header.php';
    include_once '../class/config.php';
    include_once '../class/db.php';

    $db = new db($host, $username, $password, $dbaname );

    $id = isset(  $_GET['id']  ) ? $_GET['id'] : '';

    echo $_GET['id'];

    $articulo = $db->query("SELECT * FROM posts INNER JOIN users ON posts.author_id = users.user_id WHERE post_id=$id")->fetchArray();
    // var_dump($articulo);
?>





<main class="container" style="margin-top:100px">

    <h1 class="border-bottom border-dark-subtle my-3 h3">Editar publicación</h1>
    <div class="wrapperTable">

        <form action='update_editar.php' method='POST'>
            <div class='mb-3'>
                <label for='title' class='form-label'>Autor de la publicación</label>
                <select class="form-select" id="autor" name="autor">
                    <option selected>Seleccione una opción</option>
                    <option value="<?= htmlspecialchars($articulo['user_id']) ?>" selected><?= htmlspecialchars($articulo['full_name']) ?></option>
                </select>

            </div>
            <hr>
            <div class='mb-3'>
                <label for='title' class='form-label'>Editar título</label>
                <input type='text' class='form-control' name='title' id='title'
                    value="<?= htmlspecialchars($articulo['title']) ?>">
            </div>
            <hr>
            <div class='mb-3'>
                <label for='excerpt' class='form-label'>Editar resumen</label>
                <textarea class='form-control' name='excerpt' id='excerpt' style='height: 100px'>
                        <?= htmlspecialchars($articulo['excerpt']) ?>
                    </textarea>
            </div>
            <hr>
            <div class='mb-3'>
                <label for='content' class='form-label'>Editar contenido</label>
                <textarea class='form-control content' placeholder='Ingrese descripción de la publicación'
                    name='content' id='content'
                    style='height: 200px'><?= htmlspecialchars($articulo['content']) ?></textarea>
            </div>
            <hr>
            <div class='d-grid'>
                <button type='submit' class='btn btn-secondary w-100' name='idPost' id='idPost'
                    value='<?= htmlspecialchars($articulo['post_id']) ?>'>Actualizar publicación</button>
            </div>
        </form>

    </div>

</main>

<?php  include_once 'includes/footer.php';?>