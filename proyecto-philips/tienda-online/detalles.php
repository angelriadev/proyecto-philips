<?php
    require 'assets/config/config.php';
    require 'assets/config/database.php';
    $db = new Database ();
    $con = $db->conectar();

    // Obtiene el valor del parámetro 'id' enviado por la URL. Si no existe, asigna una cadena vacía.
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    // Obtiene el valor del parámetro 'token' enviado por la URL. Si no existe, asigna una cadena vacía.
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    // Verificamos si las variables $id o $token están vacías
if($id == '' || $token == ''){
    // Si alguna de las dos está vacía, mostramos un error y detenemos la ejecución
    echo 'error al procesar la peticion';
    exit;
} else {
    // Generamos un token temporal basado en $id y una clave secreta KEY_TOKEN
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    // Comparamos el token recibido con el token generado
    if($token == $token_tmp){
        // Si los tokens coinciden, preparamos una consulta para verificar si el producto existe y está activo
        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);

        // Si el producto existe y está activo (count > 0)
        if($sql->fetchColumn() > 0){
            // Preparamos otra consulta para obtener los detalles del producto
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);

            // Almacenamos los datos del producto en un array asociativo
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre']; // Nombre del producto
            $descripcion = $row['descripcion']; // Descripción del producto
            $precio = $row['precio']; // Precio del producto
            $descuento = $row['descuento']; // Descuento en porcentaje

            // Calculamos el precio con descuento
            $precio_descuento = $precio - (($precio * $descuento) / 100);

            // Establecemos el directorio donde están las imágenes del producto
            $dir_images = 'assets/img/productos/' . $id . '/';

            // Ruta de la imagen principal del producto
            $rutaImg = $dir_images . 'principal.jpg';

            // Si la imagen principal no existe, usamos una imagen predeterminada
            if(!file_exists($rutaImg)){
                $rutaImg = 'assets/img/no-photo.jpg';
            }

            // Inicializamos un array para almacenar las imágenes adicionales
            $imagenes = array();

            // Verificamos si el directorio de imágenes existe
            if(file_exists($dir_images)){
                // Abrimos el directorio
                $dir = dir($dir_images);

                // Leemos los archivos dentro del directorio
                while(($archivo = $dir->read()) != false){
                    // Excluimos la imagen principal y añadimos solo archivos con extensiones jpg o jpeg
                    if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                        $imagenes[] = $dir_images . $archivo; // Añadimos la ruta de la imagen al array
                    }
                }
                // Cerramos el directorio
                $dir->close();
            }
        }
    } else {
        // Si los tokens no coinciden, mostramos un error y detenemos la ejecución
        echo 'error al procesar la peticion';
        exit;
    }
}
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
      background-color: <?php echo $navbarColor; ?> !important;
    }

    /* Estilo de los botones en la barra de navegación */
    .navbar-nav .nav-link {
  border-radius: 30px; /* Mismos bordes */
  padding: 10px 20px;
  background-color: <?php echo $buttonColor; ?>; /* Mismo color */
  color: <?php echo $buttonTextColor; ?>;
  font-weight: bold;
  text-align: center;
  box-shadow: <?php echo $buttonShadow; ?>;
  transition: all 0.3s ease-in-out;
}

.navbar-nav .nav-link:hover {
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4); /* Efecto hover */
  transform: translateY(-2px); /* Elevación */
  background-color: <?php echo $buttonColor; ?>; /* Color en hover */
}

    /* Ajuste en el botón de Carrito */
    .navbar .btn {
      border-radius: 30px;
      padding: 12px 30px;
      background-color: <?php echo $buttonColor; ?> !important;
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
</head>
<body>
  
<!--barra de navegacion-->
<header data-bs-theme="dark">
  <div class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <strong>Tienda online</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="php/cerrar_sesion.php" class="nav-link" style="background-color: <?php echo $buttonColor; ?>;">
              Cerrar sesión
            </a>
          </li>
          <li class="nav-item ms-3">
            <a href="#" class="nav-link" style="background-color: <?php echo $buttonColor; ?>;">
              Contacto
            </a>
          </li>
        </ul>

        <a href="botonCarrito.php" class="btn btn-primary" style="background-color: <?php echo $buttonColor; ?>;">
          Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart;?></span>
        </a>
      </div>
    </div>
  </div>
</header>
<!--contenido-->
    <main>
      <div class="container">
       <div class="row">
        <div class="col-md-6 order-md-1">

          <div id="carouselImages" class="carousel slide">
              <div class="carousel-inner">
                  <div class="carousel-item active">
                      <img src="<?php echo $rutaImg; ?>" class="img-fluid d-block w-100">
                  </div>

                  <?php foreach ($imagenes as $img) { ?>
                  <div class="carousel-item">
                      <img src="<?php echo $img; ?>" class="img-fluid d-block w-100">
                  </div>
                  <?php } ?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" style="background-color: rgba(0, 123, 255, 0.8); box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                  <span class="carousel-control-next-icon" style="background-color: rgba(0, 123, 255, 0.8); box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
              </button>
            </div>

        </div>

        <div class="col-md-6 order-md-2">
          <h2><?php echo $nombre?></h2>
<!--DESCUENTO-->
          <?php if($descuento > 0) { ?>
            <!--precio tachado-->
              <p><del><?php echo MONEDA . number_format($precio, 2, '.', ',');?></del></p> 
              <h2>
                <!--precio con descuento-->
                <?php echo MONEDA . number_format($precio_descuento, 2, '.', ',');?>
                <small class="text-success"><?php echo $descuento;?> %descuento</small>
              </h2>

            <?php }else{ ?>

              <h2><?php echo MONEDA . number_format($precio, 2, '.', ',');?></h2>

            <?php } ?>
          <p class="lead">
            <?php echo $descripcion;?>
          </p>

          <div class="d-grid gap-3 col-10 mx-auto">
              <button class="btn btn-primary" type="button" onclick="agregarYRedirigir(<?php echo $id;?>, '<?php echo $token_tmp;?>')">Comprar ahora</button>
              <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id;?>,'<?php echo $token_tmp;?>')">Agregar al carrito</button>
          </div>
        </div>
       </div> 
      </div>
    </main>
  <script>
    // Función que agrega un producto al carrito
    function addProducto(id, token){
      // Definimos la URL del archivo PHP que manejará la lógica del carrito
      let url = 'assets/clases/carrito.php';
      
      // Creamos un objeto FormData para enviar datos de forma dinámica
      let formData = new FormData();
      
      // Agregamos el id del producto y el token al FormData
      formData.append('id', id);  // 'id' es el identificador del producto
      formData.append('token', token);  // 'token' es un valor de seguridad para validar la acción

      // Realizamos la petición fetch al servidor para enviar los datos del producto al carrito
      fetch(url, {
        method: 'POST',  // Indicamos que la solicitud es de tipo POST
        body: formData,  // Enviamos los datos del producto
        mode: 'cors'  // Usamos CORS para permitir solicitudes entre dominios si es necesario
      })
      // Esperamos la respuesta del servidor
      .then(response => response.json())  // Convertimos la respuesta a formato JSON
      .then(data => {
        // Si la respuesta contiene 'ok' como verdadero, actualizamos el número de productos en el carrito
        if (data.ok) {
          let elemento = document.getElementById("num_cart");  // Obtenemos el elemento donde se muestra el número de productos
          elemento.innerHTML = data.numero;  // Actualizamos el número de productos en el carrito
        }
      });
    }
  </script>


  <script>
    function agregarYRedirigir(id, token) {
        // Función que agrega el producto al carrito
        agregarAlCarrito(id, token);

        // Redirige a botonCarrito.php
        window.location.href = 'botonCarrito.php';
    }

    // Lógica del botón "Agregar al carrito" reutilizada
    function agregarAlCarrito(id, token) {
        let url = 'assets/clases/carrito.php';
        let formData = new FormData();
        formData.append('id', id);
        formData.append('token', token);

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        })
        .then(response => response.json())
        .then(data => {
            if (data.ok) {
                let elemento = document.getElementById("num_cart");
                elemento.innerHTML = data.numero;
            }
        });
    }
  </script>
</body>
</html>