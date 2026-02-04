<?php
include_once('../class/config.php');
include_once('../class/db.php'); 


// Usuario y contraseña ingresados
$loginUsername = isset( $_POST['username'] ) ? $_POST['username'] : '';
$loginPassword = isset( $_POST['password'] ) ? $_POST['password'] : '';

$db = new db( $host, $username, $password, $dbaname );

$usuario = $db->query("SELECT * FROM users WHERE username = '$loginUsername'")->fetchArray();



if( $usuario ){
    $db_username = $usuario['username'];
    $db_password_hash = $usuario['password_hash'];

    if( password_verify(  $loginPassword , $db_password_hash ) ){
          session_start();
          $_SESSION['username'] = $db_username;
          header("Location: admin_list.php");
          exit;
    }else{
        header("Location: index.php?error=Contraseña incorrecta.");
        exit;
    }

}else{
    header("Location: index.php?error=Usuario no encontrado.");
    exit;
}

$db->close();

?>