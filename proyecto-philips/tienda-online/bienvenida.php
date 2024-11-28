<?php
  session_start();
  if(!isset($_SESSION['usuario'])){
  echo '
  <script>
  alert ("por favor,inicia sesion");
  window.location = "login_registro.php";
  </script>
  ';
    session_destroy();
    die();
  }
;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>bienvenida</title>
  <a href="php/cerrar_sesion.php"> Cerrar sesion</a>
</head>
<body>
  <h1>bienvenido</h1>
</body>
</html>