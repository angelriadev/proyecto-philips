<?php
  // Inicia una nueva sesión o reanuda la existente. Esto es necesario para poder trabajar con variables de sesión.
  session_start();

  // Destruye todos los datos registrados en la sesión actual. Esto elimina las variables de sesión, cerrando efectivamente la sesión del usuario.
  session_destroy();

  // Redirige al usuario a la página principal (index.php) después de cerrar sesión.
  header("location:../index.php");
?>