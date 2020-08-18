<?php
    session_start();
    unset($_SESSION["twitter_codigousuario"]); 
    unset($_SESSION["twitter_nombre"]);
    unset($_SESSION["twitter_apellido"]); 
    unset($_SESSION["twitter_correo"]);
    unset($_SESSION["twitter_tipousuario"]);
    session_destroy();
    header("Location: index.php");
    exit;
?>