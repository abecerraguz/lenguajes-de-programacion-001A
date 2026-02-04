<?php
    function delete_article( $id , $titulo ){
        echo "<div class='modal fade' id='eliminarPublicacion-{$id}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
         <form form action='delete.php' method='POST'>
                    <h4 class='modal-title' id='eliminarModalLabel'>Confirmar eliminación de la publicación</h4>
                    <p>$titulo</p>
                    <button type='submit' class='btn btn-danger w-100' name='idPost' id='idPost' value='$id' data-bs-dismiss='modal'>Eliminar</button>
         </form>
      </div>
    </div>
  </div>
</div>";
    }
?>