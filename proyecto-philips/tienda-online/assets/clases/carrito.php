<?php
  // Incluye el archivo de configuración para usar variables o constantes como KEY_TOKEN.
require '../config/config.php';

if(isset($_POST['id'])){ // Verifica si se ha recibido un ID a través de POST.

    $id = $_POST['id']; // Obtiene el ID del producto enviado por POST.
    $token = $_POST['token']; // Obtiene el token enviado por POST.

    // Genera un token temporal basado en el ID y la clave definida (KEY_TOKEN).
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp){ // Compara el token enviado con el generado para verificar autenticidad.

        // Si el producto ya está en el carrito, incrementa su cantidad en 1.
        if(isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] += 1;
        } else {
            // Si el producto no está en el carrito, lo agrega con cantidad inicial de 1.
            $_SESSION['carrito']['productos'][$id] = 1;
        }
        
        // Devuelve como respuesta la cantidad total de productos en el carrito.
        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true; // Indica que el proceso fue exitoso.
      
    } else { // Si el token no coincide, no se procesa la solicitud.
        $datos['ok'] = false;
    }

} else { // Si no se recibe un ID en el POST, indica un error en la solicitud.
    $datos['ok'] = false;
}

// Convierte la respuesta en formato JSON para enviarla al cliente.
echo json_encode($datos);
?>