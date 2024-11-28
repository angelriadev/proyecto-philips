<?php

require 'assets/config/config.php';
require 'assets/config/database.php';
$db = new Database ();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] :null;

//print_r($_SESSION);


$lista_carrito = array();

if($productos != null){
  foreach($productos as $clave => $cantidad){
    $sql = $con-> prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
    $sql-> execute([$clave]);
    $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
  }
}else{
  header("location: tienda.php");
  exit;
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
   <main>
  <div class="container">
    <div class="row">
      <!-- Columna izquierda con detalles de pago y botón de PayPal -->
      <div class="col-6">
        <h4>Detalles de pago</h4>
        <!-- Contenedor para el botón de PayPal (integración futura) -->
        <div id="contenedor-boton-paypal"></div>
      </div>

      <!-- Columna derecha con la tabla de los productos en el carrito -->
      <div class="col-6">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <!-- Encabezado de la tabla -->
                <th>Producto</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              // Si el carrito está vacío, se muestra un mensaje
              if ($lista_carrito == null){
                echo '<tr><td colspan="3" class="text-center"><b>Lista vacía</b></td></tr>';
              } else {
                // Si hay productos en el carrito, se calcula el total
                $total = 0;
                foreach ($lista_carrito as $producto){
                  // Se extraen los detalles de cada producto
                  $_id = $producto['id'];
                  $nombre = $producto['nombre'];
                  $precio = $producto['precio'];
                  $descuento = $producto['descuento'];
                  $cantidad = $producto['cantidad'];

                  // Se calcula el precio con descuento y el subtotal
                  $precio_descuento = $precio - (($precio * $descuento)/100);
                  $subtotal = $cantidad * $precio_descuento;
                  $total += $subtotal; // Se acumula el total
              ?>
                <tr>
                  <!-- Se muestra el nombre del producto -->
                  <td><?php echo $nombre; ?></td>
                  <td>
                    <!-- Se muestra el subtotal de cada producto con formato monetario -->
                    <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo  MONEDA . number_format($subtotal, 2, '.', ','); ?> </div>
                  </td>
                </tr>
              <?php } ?>
              
              <!-- Fila para mostrar el total general -->
              <tr>
                <td colspan="2">
                  <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2, '.', ',');?></p>
                </td>
              </tr>

            </tbody>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>

    <script src="https://sandbox.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID;?>">
</script>

<script>
  // Configuración y renderizado del botón de PayPal
  paypal.Buttons({
    style: {
      color: 'blue',  // Color del botón
      shape: 'pill',  // Forma del botón (en píldora)
      label: 'pay'    // Texto que se muestra en el botón
    },
    
    // Función para crear la orden de pago
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: <?php echo $total; ?> // Monto total a pagar, que se obtiene del valor de la variable $total
          }
        }]
      });
    },

    // Función para aprobar el pago y capturar los detalles
    onApprove: function(data, actions) {
      let URL = 'assets/clases/captura.php'; // URL donde se enviarán los detalles del pago

      // Captura de los detalles del pago una vez aprobado
      actions.order.capture().then(function(detalles) {
        console.log(detalles); // Muestra los detalles del pago en la consola para fines de depuración
        
        // Enviar los detalles del pago al servidor (por ejemplo, para almacenarlos o procesarlos)
        return fetch(URL, {
          method: 'POST', // Método de solicitud
          headers: {
            'Content-Type': 'application/json' // Tipo de contenido, en este caso JSON
          },
          body: JSON.stringify({
            detalles: detalles // Los detalles del pago se envían como datos JSON
          })
        });
      });
    },

    // Función cuando el usuario cancela el pago
    onCancel: function(data) {
      alert("Pago cancelado"); // Alerta que informa al usuario que el pago fue cancelado
      console.log(data); // Muestra los detalles del pago cancelado en la consola para depuración
    }
  }).render('#contenedor-boton-paypal'); // Renderiza el botón de PayPal dentro del contenedor con id "contenedor-boton-paypal"
</script>

  
</body>
</html>