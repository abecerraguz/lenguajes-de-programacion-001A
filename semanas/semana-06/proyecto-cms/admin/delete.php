<?php

    include_once '../class/db.php';
    include_once '../class/config.php';

    $id = isset( $_POST['idPost'] )   ? $_POST['idPost'] : ''; 

    $db = new db( $host, $username, $password, $dbaname );

    $delete = $db->query("DELETE FROM posts WHERE post_id=$id");
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    
    if( $delete ){
        header("Location:admin_list.php?info=La publicación fue eliminada correctamente !");
        exit();
    }else{
        header("Location:admin_list.php?info=La publicación no se ha eliminado correctamente !");
        exit();
    }


    // Cerrar la conexión a la base de datos
    $db->close();

    //Redirigir después de la inserción
    header("Location:adm_listado.php");


    exit();

}else{
    header("Location:adm_list.php?info=La publicación no se elimino correctamente !");
    exit();
}
?>