<?php
  // Incluye el archivo 'conexion_bk.php', que probablemente contiene la configuración para conectar con la base de datos.
  include 'conexion_bk.php';

  // Obtiene los datos enviados desde el formulario (nombre completo, correo, usuario y contraseña).
  $nombre_completo = $_POST['nombre_completo'];
  $correo = $_POST['correo'];
  $usuario = $_POST['usuario'];
  $contrasena = $_POST['contrasena'];

  // Encripta la contraseña usando el algoritmo SHA-512 para mayor seguridad.
  $contrasena = hash('sha512', $contrasena);

  // Consulta SQL para insertar un nuevo registro en la tabla 'usuarios' con los datos proporcionados.
  $query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena) 
            VALUES('$nombre_completo', '$correo', '$usuario', '$contrasena')"; 

  // Verifica si el nombre completo ya existe en la base de datos.
  $verificar_nombre = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre_completo ='$nombre_completo'");
  if (mysqli_num_rows($verificar_nombre) > 0) {
    // Si el nombre ya está registrado, muestra un mensaje de alerta y redirige al formulario de registro.
    echo '
    <script>
      alert("este nombre ya esta registrado, intenta con otro diferente");
      window.location ="../login_registro.php"
    </script>';
    exit();  // Detiene la ejecución del código.
  }

  // Verifica si el correo electrónico ya existe en la base de datos.
  $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo ='$correo'");
  if (mysqli_num_rows($verificar_correo) > 0) {
    // Si el correo ya está registrado, muestra un mensaje de alerta y redirige al formulario de registro.
    echo '
    <script>
      alert("este correo ya esta registrado, intenta con otro diferente");
      window.location ="../login_registro.php"
    </script>';
    exit();  // Detiene la ejecución del código.
  }

  // Verifica si el nombre de usuario ya existe en la base de datos.
  $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario ='$usuario'");
  if (mysqli_num_rows($verificar_usuario) > 0) {
    // Si el usuario ya está registrado, muestra un mensaje de alerta y redirige al formulario de registro.
    echo '
    <script>
      alert("este usuario ya esta registrado, intenta con otro diferente");
      window.location ="../login_registro.php"
    </script>';
    exit();  // Detiene la ejecución del código.
  }

  // Ejecuta la consulta SQL para insertar el nuevo usuario en la base de datos.
  $ejecutar = mysqli_query($conexion, $query);

  // Si la consulta fue exitosa, muestra un mensaje de éxito.
  if ($ejecutar) {
    echo '
    <script>
      alert("usuario almacenado exitosamente");
      window.location ="../login_registro.php"
    </script>';
  } else {
    // Si no se pudo almacenar el usuario, muestra un mensaje de error.
    echo '
    <script>
      alert("no se pudo crear el usuario");
      window.location ="../login_registro.php"
    </script>';
  }

  // Cierra la conexión con la base de datos.
  mysqli_close($conexion);
?>
