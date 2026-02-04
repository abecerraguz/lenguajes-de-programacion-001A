<?php
    include_once 'includes/header.php';
    include_once '../class/config.php';
    include_once '../class/db.php';

?>
    <!-- Cierre del header -->
    <main class="container" style="margin-top:100px">

        <h1 class="border-bottom border-dark-subtle my-3 h3">Insertar publicación</h1>
        <div class="wrapperTable">

        <form action="post_insertar.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" name="title" id="title" placeholder="Ingrese titulo"
                    required>
            </div>
            <div class="mb-3">
                <textarea class="form-control" placeholder="Ingrese resumen de la publicación"
                    name="excerpt" id="excerpt" style="height: 100px"></textarea>
            </div>
            <div class="mb-3">
                <textarea class="form-control content" placeholder="Ingrese descripción de la publicación"
                    name="content" id="content" style="height: 200px"></textarea>
            </div>
      
            <div class='d-grid gap-2'>
               <input type="submit" class="btn btn-secondary w-100" value="Guardar la publicación">


            </div>

        </form>
        
    </div>

    </main>

<?php  include_once 'includes/footer.php';?>

 