<?php

require '../config/config.php';
require '../config/database.php';
$db = new Database ();
$con = $db->conectar();

//RECEPCION DE LA INFORMACION
// Obtiene el contenido bruto enviado al servidor como JSON en el cuerpo de la solicitud.
$json = file_get_contents('php://input');

// Decodifica el JSON a un arreglo asociativo de PHP.
$datos = json_decode($json, true);

// Imprime los datos decodificados para verificar el contenido (normalmente usado en pruebas o depuración).
print_r($datos);

if(is_array($datos)){ // Verifica que los datos decodificados sean un arreglo válido.
    
    // Extrae información de la transacción desde el JSON decodificado.
    $id_transaccion = $datos['detalles']['id']; // ID de la transacción.
    $total = $datos['detalles']['purchase_units'][0]['amount']['value']; // Total de la compra.
    $status = $datos['detalles']['status']; // Estado de la transacción.
    $fecha = $datos['detalles']['update_time']; // Fecha de la transacción en formato original.
    // Convierte la fecha al formato 'Y-m-d H:i:s' para guardar en la base de datos.
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address']; // Email del comprador.
    $id_cliente = $datos['detalles']['payer']['payer_id']; // ID del cliente.

    // Inserta los datos de la transacción en la tabla `compra`.
    $sql = $con->prepare("INSERT INTO compra(id_transaccion, fecha, status, email, id_cliente, total) VALUES (?,?,?,?,?,?)");
    $sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);
    // Obtiene el ID generado para la compra recién registrada.
    $id = $con->lastInsertId();

    if($id > 0){ // Verifica que el registro de la compra fue exitoso.
        
        // Recupera los productos almacenados en el carrito de la sesión.
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if($productos != null){ // Si hay productos en el carrito, los procesa.
            foreach($productos as $clave => $cantidad){ // Recorre cada producto en el carrito.

                // Consulta los datos del producto desde la base de datos.
                $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo=1");
                $sql->execute([$clave]); // Utiliza el ID del producto como parámetro.
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC); // Obtiene los datos del producto.

                // Calcula el precio del producto aplicando el descuento, si existe.
                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_descuento = $precio - (($precio * $descuento) / 100);

                // Inserta los detalles del producto en la tabla `detalle_compra`.
                $sql_insert = $con->prepare("INSERT INTO detalle_compra(id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_descuento, $cantidad]);
            }
        }

        // Limpia el carrito eliminándolo de la sesión después de procesar la compra.
        unset($_SESSION['carrito']);
    }
}
?>