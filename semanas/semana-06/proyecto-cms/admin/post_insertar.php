<?php

    include_once '../class/db.php';
    include_once '../class/config.php';

    $titulo =  isset( $_POST['title'] )   ? $_POST['title']   :   '';  
    $resumen = isset( $_POST['excerpt'] ) ? $_POST['excerpt'] : '';
    $texto =   isset( $_POST['content'] ) ? $_POST['content'] : '';
    $autor = 1;


    if($_SERVER['REQUEST_METHOD'] == "POST"){
            
        $db = new db( $host, $username, $password, $dbaname );
        $insert = $db->query('INSERT INTO posts (title, publish_date, excerpt, content, author_id) values ("' .$titulo. '", NOW() , "' . $resumen .'", "' . $texto . '", ' . $autor . ')');

        if( $insert){
            header("Location:admin_list.php?info=La publicación se inserto correctamente !");
            exit();
        }else{
            header("Location:admin_list.php?info=La publicación no se inserto correctamente !");
            exit();
        }
        // Cerrar la conexión a la base de datos
        $db->close();

        //Redirigir después de la inserción
        header("Location:adm_listado.php");
        exit();
    }else{
        header("Location:admin_list.php?info=El metodo de consulta no es POST!");
        exit();
    }

