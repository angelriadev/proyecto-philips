<?php
// Se requieren archivos de configuración y conexión a la base de datos
require 'assets/config/config.php'; 
require 'assets/config/database.php';

// Se crea una instancia de la clase Database y se establece la conexión
$db = new Database(); 
$con = $db->conectar();

// Se realiza una consulta a la base de datos para obtener los productos activos
$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 

//session_destroy();

  $navbarColor = 'rgb(12, 94, 215)'; // Barra de navegación con el color solicitado
  $buttonColor = 'rgb(39, 162, 255)'; // Botones más claros
  $buttonShadow = '0px 6px 12px rgba(0, 0, 0, 0.3)'; // Sombra más fuerte
  $buttonTextColor = 'white'; // Color blanco para el texto

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda online</title>

  <link href="assets/css/estilo.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <style>
    /* Barra de navegación con el color solicitado */
    .navbar {
      background-color: <?php echo $navbarColor; ?>;
    }

    /* Estilo de los botones en la barra de navegación */
    .navbar-nav .nav-link {
      border-radius: 30px; /* Bordes más suaves */
      padding: 10px 20px; /* Ajuste en el tamaño de los botones */
      color: <?php echo $buttonTextColor; ?>;
      font-weight: bold;
      text-align: center;
      box-shadow: <?php echo $buttonShadow; ?>; /* Sombra sutil */
      transition: all 0.3s ease-in-out; /* Transición suave */
    }

    .navbar-nav .nav-link:hover {
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4); /* Sombra más intensa en hover */
      transform: translateY(-2px); /* Efecto de elevación */
      background-color: <?php echo $buttonColor; ?>; /* Resaltar el fondo del botón al hacer hover */
    }

    /* Ajuste en el botón de Carrito */
    .navbar .btn {
      border-radius: 30px;
      padding: 12px 30px;
      color: <?php echo $buttonTextColor; ?>;
      font-weight: bold;
      text-align: center;
      box-shadow: <?php echo $buttonShadow; ?>; /* Sombra sutil */
      transition: all 0.3s ease-in-out; /* Transición suave */
    }

    .navbar .btn:hover {
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4); /* Sombra más intensa en hover */
      transform: translateY(-2px); /* Efecto de elevación */
      background-color: <?php echo $buttonColor; ?>; /* Resaltar el fondo al hacer hover */
    }
  </style>
  
  <!--ESTILO BOTONES PRODUCTOS-->
 <style>
    .navbar-nav .nav-link {
      border-radius: 30px;
      padding: 10px 20px;
      box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2); /* Sombra suave */
      transition: all 0.3s ease-in-out; /* Transición suave */
    }

    .navbar-nav .nav-link:hover {
      box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.4); /* Sombra más fuerte al pasar el mouse */
      transform: translateY(-4px); /* Efecto de elevación más fuerte */
      background-color: <?php echo $buttonColor; ?>; /* Resaltar el fondo al hacer hover */
    }

    .btn {
      border-radius: 30px; /* Bordes redondeados */
      padding: 12px 30px; /* Tamaño adecuado para botones grandes */
      box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3); /* Sombra sutil */
      transition: all 0.3s ease-in-out; /* Transición suave */
    }

    .btn:hover {
      box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.5); /* Sombra más fuerte en hover */
      transform: translateY(-4px); /* Efecto de elevación en hover más intenso */
      background-color: <?php echo $buttonColor; ?>; /* Resaltar el fondo al hacer hover */
    }

    /* Estilo específico para el botón 'Agregar al carrito' */
    .btn-outline-success {
      background-color: green; /* Color verde para el botón */
      color: white;
    }

    .btn-outline-success:hover {
      background-color: darkgreen; /* Color más oscuro en hover */
      box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.5);
      transform: translateY(-4px);
    }
</style>

<style>
  /* Aumenta la separación entre las columnas de las tarjetas */
.col {
  border: 1px solid rgba(0, 0, 0, 0.1); /* Borde suave y sutil */
  transition: all 0.3s ease-in-out; /* Transición suave */
  margin-bottom: 30px; /* Aumento de la separación inferior entre tarjetas */
}

.col:hover {
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 1); /* Sombra más definida y oscura al hacer hover */
  transform: translateY(-5px); /* Leve elevación al hacer hover */
}

.card {
  border:none; /* Borde suave y sutil */
  border-radius: 8px; /* Esquinas redondeadas */
  margin: 15px; /* Aumento de la separación alrededor de la tarjeta */
}

.card-body {
  padding: 15px; /* Ajuste en el espacio interno */
}
</style>

</head>
<body>
  
  <!-- Barra de navegación con el color solicitado y los botones separados -->
  <header data-bs-theme="dark">
    <div class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <!-- Logo y nombre de la tienda -->
        <a href="#" class="navbar-brand">
          <strong>Tienda online</strong>
        </a>
        <!-- Botón para colapsar el menú en dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú desplegable de la barra de navegación -->
        <div class="collapse navbar-collapse" id="navbarHeader">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- Opción de cerrar sesión -->
            <li class="navbar-item">
              <a href="php/cerrar_sesion.php" class="nav-link" style="background-color: <?php echo $buttonColor; ?>;">
                Cerrar sesión
              </a>
            </li>
            <!-- Opción de contacto -->
            <li class="navbar-item" style="margin-left: 15px;">
              <a href="#" class="nav-link" style="background-color: <?php echo $buttonColor; ?>;">
                Contacto
              </a>
            </li>
          </ul>

          <!-- Botón del carrito con la cantidad de productos en él -->
          <a href="botonCarrito.php" class="btn btn-primary" style="background-color: <?php echo $buttonColor; ?>;">
            Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart;?></span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Contenido principal de la página -->
  <main>
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <!-- Bucle para mostrar los productos desde la base de datos -->
        <?php foreach($resultado as $row){ ?>
          <div class="col">
            <!-- Tarjeta del producto con sombra -->
            <div class="card shadow-sm">
              <?php
                // Se obtiene el ID del producto
                $id = $row['id'];
                // Se establece la ruta de la imagen principal del producto
                $imagen = "assets/img/productos/$id/principal.jpg";

                // Si no existe la imagen, se usa una imagen por defecto
                if (!file_exists($imagen)) {
                  $imagen="assets/img/no-photo.jpg";
                } 
              ?>
              <!-- Imagen del producto -->
              <img src="<?php echo $imagen;?>">
              <div class="card-body">
                <!-- Nombre del producto -->
                <h5 class="card-title"><?php echo  $row['nombre'];?></h5>
                <!-- Precio del producto, formateado con dos decimales -->
                <p class="card-text"><?php echo number_format( $row['precio'], 2, '.', ',');?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <!-- Enlace a la página de detalles del producto -->
                    <a href="detalles.php?id=<?php echo $row['id'];?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN);?>" class="btn btn-primary">Detalles</a>
                  </div>
                  <!-- Botón para agregar el producto al carrito, ejecuta una función JavaScript -->
                  <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id'];?>,'<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN);?>')">Agregar al carrito</button>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </main>

  <!-- Script para manejar la acción de agregar un producto al carrito -->
  <script>
    function addProducto(id, token){
      // Definir la URL del archivo PHP que maneja el carrito
      let url = 'assets/clases/carrito.php';
      
      // Crear un objeto FormData para enviar los datos del producto
      let formData = new FormData();
      formData.append('id', id); // Agregar el ID del producto
      formData.append('token', token); // Agregar el token de seguridad

      // Hacer una solicitud fetch al servidor
      fetch(url, {
        method: 'POST', // Enviar los datos como POST
        body: formData, // Enviar los datos del formulario
        mode: 'cors' // Usar CORS para permitir solicitudes de diferentes dominios
      })
      .then(response => response.json()) // Procesar la respuesta como JSON
      .then(data => {
        if(data.ok){ // Si la respuesta es positiva (producto agregado correctamente)
          // Actualizar el número de productos en el carrito
          let elemento = document.getElementById("num_cart");
          elemento.innerHTML = data.numero; // Mostrar el número actualizado en la interfaz
        }
      })
    }
  </script>
</body>
</html>