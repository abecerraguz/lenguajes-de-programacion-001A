<?php
        include_once '../class/db.php';
        include_once '../class/config.php';

        $titulo  =   isset( $_POST['title'] ) ? $_POST['title'] : '';  
        $resumen =   isset( $_POST['excerpt'] ) ? $_POST['excerpt'] : '';
        $texto   =   isset( $_POST['content'] )   ? $_POST['content'] : '';

        $autorId =   intval( isset( $_POST['autor'] )   ? $_POST['autor'] : '' );
        // $datetime = new DateTime();
        // $fecha = $datetime->format('Y-m-d H:i:s'); 
        $id = isset( $_POST['idPost'] )   ? $_POST['idPost'] : '';

    

   



        if($_SERVER['REQUEST_METHOD'] == "POST"){
            
            $db = new db( $host, $username, $password, $dbaname );
            $update = $db->query("UPDATE posts SET title='".$titulo."', author_id='".$autorId."', publish_date=NOW(), excerpt='".$resumen."', content='".$texto."' 
            WHERE post_id=$id");

            if( $update ){
                header("Location:admin_list.php?info=La publicación se actualizo correctamente !");
                exit();
            }else{
                header("Location:admin_list.php?info=La publicación no se ha actualizado correctamente !");
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




        
?>