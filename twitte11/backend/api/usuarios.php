<?php
// session_start(); Permite acceder a las variables de sesion
include_once("../clases/class-usuario.php");

// echo 'Informacion: '. file_get_contents('php://input');
header("Content-Type: application/json");

switch ($_SERVER['REQUEST_METHOD']) {  
    case 'POST': //insertar un usuario
        $_POST = json_decode(file_get_contents('php://input'), true);
        $usuario = new Usuario($_POST["nombre"], $_POST["apellido"], $_POST["correo"], $_POST["fechaNacimiento"], $_POST["contrasena"]);
        $fin = $usuario->guardarUsuario(); 
        if ($fin["resultado"] != 0) { // El usuario se registro, datos validos
            // // ◘◘◘ VARIABLES DE SESION
            // $_SESSION["twitter_codigousuario"] = $fin["codigoUsuario"]; // EXTREAER CODIGO
            // $_SESSION["twitter_nombre"] = $_POST["nombre"];
            // $_SESSION["twitter_apellido"] = $_POST["apellido"];
            // $_SESSION["twitter_correo"] = $_POST["correo"];
            
            // $_SESSION["twitter_tipousuario"] = $_POST["tipoUsuario"];
            echo $fin["resultado"];
        }
        else {
            echo $fin["resultado"];
        }
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            Usuario::obtenerUsuario($_GET['id']);
        }
        else if ( isset($_GET["correo"]) || isset($_GET["contrasena"]) )  {
            Usuario::validarInicioSesion($_GET['correo'], $_GET["contrasena"]); //llamo al metodo validadinicioSesion
            // ◘◘◘ VARIABLES DE SESION
            // $_SESSION["twitter_codigousuario"] = $fin["codigoUsuario"]; // EXTREAER CODIGO
            // $_SESSION["twitter_nombre"] = $fin["nombre"]; // EXTRAER NOMBRE
            // $_SESSION["twitter_apellido"] = $fin["apellido"]; // EXTRAER APELLIDO
            // $_SESSION["twitter_correo"] = $_POST["correo"];
            // $_SESSION["twitter_tipousuario"] = $fin["tipoUsuario"]; // EXTRAER TIPO DE USUARIO
        }
        else {
            Usuario::obtenerUsuarios();
        }
        break;
    case 'PUT': 
    
        break;
    case 'DELETE':
        
        break;
}
    
    //CRUD 
    // Crear

    // Obtener un usuario

    // Obtener todos los usuarios

    // Actualizar un usuario

    // Eliminar un usuario
