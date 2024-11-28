<?php
  // Define el ID de cliente utilizado para la integración con PayPal
  define("CLIENT_ID","AXTEwrBIhnSt5cNFFE3BDdEpVUs_4D-Fkf8Za-FYoGJ_T-FdZ4M9qRwfpbmB1-aRHdcXaLcGOA5wohvG");

  // Moneda que se utilizará en el sistema, actualmente está definido para usar pesos mexicanos (MXN)
  // define("CURRENCY","MXN");

  // Define la clave secreta para generar y verificar tokens de seguridad
  define("KEY_TOKEN","ABC,abc-123.");

  // Define el símbolo de la moneda a utilizar en la visualización de precios
  define("MONEDA","$");

  // Inicia la sesión, lo que permite gestionar variables de sesión en el navegador
  session_start();

  // Inicializa la variable num_cart a 0, que se usará para contar los productos en el carrito
  $num_cart = 0;

  // Verifica si la variable de sesión 'carrito' existe y tiene productos
  if(isset($_SESSION['carrito']['productos'])){
    // Si existen productos, asigna a num_cart el número de productos en el carrito
    $num_cart  = count($_SESSION['carrito']['productos']);
  }
?>