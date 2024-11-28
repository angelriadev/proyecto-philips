<?php

// Definición de la clase Database, que se encargará de manejar la conexión a la base de datos.
class Database{
  
  // Propiedades privadas para almacenar los parámetros de conexión a la base de datos.
  private $hostname = "localhost";  // El servidor donde se aloja la base de datos.
  private $database = "tienda_online_db";  // El nombre de la base de datos.
  private $username = "root";  // El nombre de usuario para acceder a la base de datos.
  private $password = "";  // La contraseña del usuario de la base de datos.
  private $charset = "utf8";  // El conjunto de caracteres para la conexión.

  // Función para conectar a la base de datos.
  function conectar(){
  
    try{
      // Creación de la cadena de conexión, concatenando los parámetros necesarios.
      $conexion ="mysql:host=".$this->hostname . ";dbname=" .$this->database . "; charset=" .$this->charset;
      
      // Definición de las opciones para la conexión PDO.
      $options =[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Modo de error para que PDO lance excepciones.
        PDO::ATTR_EMULATE_PREPARES => false  // Deshabilita la emulación de sentencias preparadas.
      ];

      // Creación del objeto PDO para conectar a la base de datos.
      $pdo = new PDO($conexion, $this->username, $this->password, $options);
      
      // Retorno del objeto PDO que representa la conexión a la base de datos.
      return $pdo;
    }catch(PDOException $e){
      // Si ocurre un error al intentar conectar, se muestra el mensaje de error.
      echo 'error de conexion'.$e->getMessage();
      exit;  // Detiene la ejecución del script en caso de error.
    }
  }
}

?>
