<?php
header("Content-Type: application/json");
include_once("../clases/class-twit.php");
$_POST = json_decode(file_get_contents('php://input'), true);
// session_start(); // Permite acceder a las variables de sesion

// echo 'Informacion: '. file_get_contents('php://input');


switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);
        // $twit = new Twit($_SESSION["codigoUsuario"],$_POST["contenidoTwit"],$_POST["imagen"],$_POST["cantidadReTwits"],$_POST["codigoTwitOriginal"]);
        $twit = new Twit(1,$_POST["contenidoTwit"],$_POST["imagen"],$_POST["cantidadReTwits"],$_POST["codigoTwitOriginal"]);
        $fin = $twit->guardarTwit();
        echo $fin;
        break;
    case 'GET':
        Twit::obtenerTwits();
        break;
    case 'PUT': 
    
        break;
    case 'DELETE':
        
        break;
}