<?php


class Usuario
{ 
  // private $codigoUsuario;
  private $nombre;
  private $apellido;
  private $correo;
  private $fechaNacimiento;
  private $contrasena;
  
  public function __construct($nombre, $apellido, $correo, $fechaNacimiento, $contrasena)
  {
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->correo = $correo;
    $this->fechaNacimiento = $fechaNacimiento;
    $this->contrasena = $contrasena;
  }


  /**
   * Get the value of nombre
   */
  public function getNombre()
  {
    return $this->nombre;
  }

  /**
   * Set the value of nombre
   *
   * @return  self
   */
  public function setNombre($nombre)
  {
    $this->nombre = $nombre;

    return $this;
  }

  /**
   * Get the value of apellido
   */
  public function getApellido()
  {
    return $this->apellido;
  }

  /**
   * Set the value of apellido
   *
   * @return  self
   */
  public function setApellido($apellido)
  {
    $this->apellido = $apellido;

    return $this;
  }

  /**
   * Get the value of fechaNacimiento
   */
  public function getFechaNacimiento()
  {
    return $this->fechaNacimiento;
  }

  /**
   * Set the value of fechaNacimiento
   *
   * @return  self
   */
  public function setFechaNacimiento($fechaNacimiento)
  {
    $this->fechaNacimiento = $fechaNacimiento;

    return $this;
  }

  /**
   * Get the value of correo
   */
  public function getCorreo()
  {
    return $this->correo;
  }

  /**
   * Set the value of correo
   *
   * @return  self
   */
  public function setCorreo($correo)
  {
    $this->correo = $correo;

    return $this;
  }

  /**
   * Get the value of contrasena
   */
  public function getContrasena()
  {
    return $this->contrasena;
  }

  /**
   * Set the value of contrasena
   *
   * @return  self
   */
  public function setContrasena($contrasena)
  {
    $this->contrasena = $contrasena;

    return $this;
  }


  public function __toString()
  {
    return $this->nombre . " " . $this->apellido . " " . $this->correo . " " . $this->fechaNacimiento . " " . $this->contrasena . "";
  }

  public function guardarUsuario()
  {
    $contenidoArchivo = file_get_contents("../data/usuarios.json");
    $usuarios = json_decode($contenidoArchivo, true);
    $respuesta["codigoUsuario"] = date("dmYhisa");
    $usernameRepetido = 0;
    for ($i=0; $i < count($usuarios); $i++) {
      if($usuarios[$i]["correo"] == $this->correo) {
        $usernameRepetido = 1;
      }
    }
    if ($usernameRepetido == 0) {
      $usuarios[] = array( //arreglo asosiativo
        "codigoUsuario" => $respuesta["codigoUsuario"], // El codigo del usuario sera fecha y hora actual, ejemplo: 17082020120935pm
        "nombre" => $this->nombre,
        "apellido" => $this->apellido,
        "correo" => $this->correo,
        "fechaNacimiento" => $this->fechaNacimiento,
        "contrasena" => $this->contrasena
      );
      $archivo = fopen("../data/usuarios.json", "w");
      fwrite($archivo, json_encode($usuarios));
      fclose($archivo);
      $respuesta["resultado"] = 1;
      return $respuesta; // Usuario registrado con exito, se retorna el codigo asignado
    } else {
      $respuesta["resultado"] = 0;
      return $respuesta; // Si ya existe un usuario con el mismo correo, no se registra
    }
  }


  public static function obtenerUsuarios()
  {
    $contenidoArchivo = file_get_contents("../data/usuarios.json");
    echo $contenidoArchivo;
  }

  public static function obtenerUsuario($indice)
  {
    $contenidoArchivo = file_get_contents("../data/usuarios.json");
    $usuarios = json_decode($contenidoArchivo, true);
    echo json_encode($usuarios[$indice]);
  }

  public static function validarInicioSesion($email, $password)
  {
    $contenidoArchivo = file_get_contents("../data/usuarios.json");
    $usuarios = json_decode($contenidoArchivo, true);  
    $respuesta = 0; // Si las credenciales de entrada son incorrectas se retorna 0
    for ($i=0; $i < count(json_decode($contenidoArchivo)); $i++) {
      if($usuarios[$i]["correo"] == $email && $usuarios[$i]["contrasena"] == $password) {
        $respuesta = 1; // Si las credenciales de entrada son correctas se retorna 1
      }
    }
    echo $respuesta; // ◘◘◘ Retornar codigoUsuario y tipoUsuario
  }
}
