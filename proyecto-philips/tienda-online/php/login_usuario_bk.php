<?php
  // Inicia la sesión, permitiendo acceder y gestionar variables de sesión.
  session_start();

  // Incluye el archivo 'conexion_bk.php' que contiene la conexión a la base de datos.
  include 'conexion_bk.php';

  // Obtiene los datos enviados por el formulario de login (correo y contraseña).
  $correo = $_POST['correo'];
  $contrasena = $_POST['contrasena'];

  // Hashea la contraseña utilizando el algoritmo SHA-512 para mayor seguridad.
  $contrasena = hash('sha512', $contrasena);

  // Realiza una consulta SQL para verificar si existe un usuario con el correo y la contraseña proporcionados.
  // La consulta selecciona todos los registros de la tabla 'usuarios' donde el correo y la contraseña coincidan.
  $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo ='$correo' and contrasena = '$contrasena'");

  // Si la consulta devuelve al menos un registro (es decir, el usuario existe), se valida el login.
  if (mysqli_num_rows($validar_login) > 0) {
    // Asigna el correo del usuario a la variable de sesión 'usuario'.
    $_SESSION['usuario'] = $correo;
    
    // Redirige al usuario a la página 'tienda.php' después de un inicio de sesión exitoso.
    header("location: ../tienda.php");
    exit;
  } else {
    // Si no se encuentra el usuario en la base de datos, muestra una alerta.
    echo '
      <script>
        alert("usuario no existe");
        window.location ="../login_registro.php"
      </script>
    ';
    exit;
  }
?>