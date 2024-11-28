<?php

require 'assets/config/config.php';
require 'assets/config/database.php';
$db = new Database ();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] :null;

//print_r($_SESSION);


// Inicializa un array vacío para almacenar los productos del carrito
$lista_carrito = array();

// Verifica si la variable $productos no es nula
if($productos != null){
    // Recorre cada producto en el array $productos, donde $clave es el ID del producto y $cantidad es la cantidad
    foreach($productos as $clave => $cantidad){
        // Prepara una consulta para obtener los datos del producto (id, nombre, precio, descuento)
        // y añade la cantidad como un valor adicional
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        // Ejecuta la consulta con el ID del producto como parámetro
        $sql->execute([$clave]);
        // Agrega el resultado de la consulta al array $lista_carrito
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}


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
<main>
  <div class="container">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <!-- Encabezados de la tabla -->
            <th>Producto</th> <!-- Columna para el nombre del producto -->
            <th>Precio</th> <!-- Columna para el precio unitario -->
            <th>Cantidad</th> <!-- Columna para la cantidad del producto -->
            <th>Subtotal</th> <!-- Columna para el subtotal (precio * cantidad) -->
            <th></th> <!-- Columna para el botón de eliminar producto -->
          </tr>
        </thead>
        <tbody>
          <!-- Comprobamos si el carrito está vacío -->
          <?php if ($lista_carrito == null){
            // Si no hay productos en el carrito, mostramos un mensaje de "Lista vacía"
            echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
          } else {
            // Si el carrito tiene productos, comenzamos a mostrar los productos
            $total = 0; // Inicializamos la variable total
            foreach ($lista_carrito as $producto){
              // Asignamos las variables correspondientes a cada producto
              $_id = $producto['id']; // ID del producto
              $nombre = $producto['nombre']; // Nombre del producto
              $precio = $producto['precio']; // Precio original
              $descuento = $producto['descuento']; // Descuento aplicado al producto
              $cantidad = $producto['cantidad']; // Cantidad del producto en el carrito
              $precio_descuento = $precio - (($precio * $descuento) / 100); // Calculamos el precio con descuento
              $subtotal = $cantidad * $precio_descuento; // Calculamos el subtotal para ese producto
              $total += $subtotal; // Acumulamos el total con el subtotal de cada producto
          ?>
            <!-- Fila para cada producto en el carrito -->
            <tr>
              <!-- Mostramos el nombre del producto -->
              <td><?php echo $nombre; ?></td> 
              <!-- Mostramos el precio con descuento del producto -->
              <td><?php echo MONEDA . number_format($precio_descuento, 2, '.', ','); ?></td> 
              <td>
                <!-- Campo para editar la cantidad del producto -->
                <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>"
                size="5" id="cantidad_<?php echo $_id;?>" onchange="actualizaCantidad(this.value, <?php echo $_id;?>)">
              </td>
              <td>
                <!-- Mostramos el subtotal para ese producto -->
                <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?> </div>
              </td>
              <td>
                <!-- Botón para eliminar el producto -->
                <a href="#" id="eliminar" class="btn btn-danger btn-sm" 
                  style="background-color: #dc3545; border-color: #dc3545; 
                         box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.7); 
                         transition: all 0.3s ease-in-out;" 
                  onmouseover="this.style.boxShadow = '0px 10px 20px rgba(0, 0, 0, 1)'; this.style.transform = 'translateY(-2px)';"
                  onmouseout="this.style.boxShadow = '0px 6px 12px rgba(0, 0, 0, 0.7)'; this.style.transform = 'translateY(0)';"
                  data-bs-id="<?php echo $_id;?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">
                  Eliminar
                </a>
              </td>
            </tr>
          <?php } ?>
          
          <!-- Fila para mostrar el total del carrito -->
          <tr>
            <td colspan="3"></td> <!-- Espacio vacío en las primeras tres columnas -->
            <td colspan="2">
              <!-- Mostramos el total del carrito -->
              <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ',');?></p>
            </td>
          </tr>
        </tbody>
        <?php } ?>
      </table>
    </div>

    <!-- Si hay productos en el carrito, mostramos el botón para proceder al pago -->
    <?php if ($lista_carrito != null){ ?>
    <div class="row">
      <div class="col-md-5 offset-md-7 d-grid gap-2">
        <!-- Botón que redirige a la página de pago -->
        <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
      </div>
    </div>
    <?php } ?>

  </div>
</main>



      <!-- Modal -->
  <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ¿Desea eliminar el producto de la lista?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
    <script>
  // Se obtiene el modal de eliminación de producto
  let eliminaModal = document.getElementById('eliminaModal')

  // Se agrega un evento al modal para cuando se muestre
  eliminaModal.addEventListener('show.bs.modal', function(event){
    // Obtiene el botón que activó el modal
    let button = event.relatedTarget
    // Obtiene el id del producto desde el atributo 'data-bs-id' del botón
    let id = button.getAttribute('data-bs-id')
    // Obtiene el botón de eliminación en el pie del modal
    let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
    // Asigna el id del producto al valor del botón de eliminación
    buttonElimina.value = id
  })

  // Función para actualizar la cantidad del producto en el carrito
  function actualizaCantidad(cantidad, id){
    // URL del archivo PHP que actualiza el carrito
    let url = 'assets/clases/actualizar_carrito.php';
    // Crear un objeto FormData para enviar los datos
    let formData = new FormData()
    formData.append('id', id)  // Agrega el id del producto
    formData.append('action', 'agregar')  // Acción para agregar cantidad
    formData.append('cantidad', cantidad)  // Nueva cantidad

    // Envío de los datos por fetch
    fetch(url, {
      method: 'POST',  // Método POST
      body: formData,  // Cuerpo con los datos
      mode: 'cors'     // Modo CORS para permitir acceso desde otros orígenes
    })
    .then(response => response.json())  // Respuesta en formato JSON
    .then(data => {
      // Si la respuesta es exitosa
      if(data.ok){
        // Actualiza el subtotal del producto
        let divsubtotal = document.getElementById('subtotal_' + id)
        divsubtotal.innerHTML = data.sub

        // Calcular el total actualizado
        let total = 0.00
        let list = document.getElementsByName('subtotal[]')

        // Sumar todos los subtotales
        for(let i = 0; i < list.length; i++){
          total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
        }

        // Formatear el total a dos decimales
        total = new Intl.NumberFormat('en-US', {
          minimumFractionDigits: 2
        }).format(total)

        // Actualizar el total en el carrito
        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total
      }
    })
  }

  // Función para eliminar un producto del carrito
  function eliminar(){
    // Se obtiene el botón de eliminación
    let botonElimina = document.getElementById('btn-elimina')
    // Se obtiene el id del producto desde el valor del botón
    let id = botonElimina.value

    // URL del archivo PHP que actualiza el carrito
    let url = 'assets/clases/actualizar_carrito.php';
    // Crear un objeto FormData para enviar los datos
    let formData = new FormData()
    formData.append('id', id)  // Agrega el id del producto
    formData.append('action', 'eliminar')  // Acción para eliminar

    // Envío de los datos por fetch
    fetch(url, {
      method: 'POST',  // Método POST
      body: formData,  // Cuerpo con los datos
      mode: 'cors'     // Modo CORS para permitir acceso desde otros orígenes
    })
    .then(response => response.json())  // Respuesta en formato JSON
    .then(data => {
      // Si la respuesta es exitosa
      if(data.ok){
        // Recarga la página para actualizar el carrito
        location.reload()
      }
    })
  }
</script>

</body>
</html>