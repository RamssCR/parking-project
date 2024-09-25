<?php
session_start();
include_once("./config/config.php");


$userId = $_SESSION['user_id'];

// Función para validar el correo electrónico
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Obtener detalles del cliente desde el formulario
$nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING);
$telefono = filter_var(trim($_POST['telefono']), FILTER_SANITIZE_STRING);
$cedula = filter_var(trim($_POST['cedula']), FILTER_SANITIZE_STRING);
$correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
$direccion = filter_var(trim($_POST['direccion']), FILTER_SANITIZE_STRING);

if (!validateEmail($correo)) {
    die("El correo electrónico proporcionado no es válido.");
}

$metodo_pago = $_SESSION['metodo_pago'] ?? 'contado';

try {
    $conn->beginTransaction();

    // Insertar datos del cliente
    $stmt = $conn->prepare("INSERT INTO clientes (nombre, telefono, cedula, correo, direccion) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $telefono, $cedula, $correo, $direccion]);

    // Obtener detalles del carrito del usuario
    $stmt = $conn->prepare("
        SELECT c.id, c.user_id, c.producto_id, c.cantidad, c.subtotal, c.tipo_compra, c.fecha_agregado,
               p.nombre_producto, p.precio_contado, p.precio_credito, p.imagen, p.precio_fijo, p.tipo_producto
        FROM carrito c
        JOIN productos p ON c.producto_id = p.id_producto
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $productDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular el total de la compra
    $totalCompra = array_sum(array_column($productDetails, 'subtotal'));

    // Insertar registro en la tabla de pedidos
    $stmt = $conn->prepare("
        INSERT INTO pedidos (user_id, estado, total, metodo_pago)
        VALUES (?, 'pendiente', ?, ?)
    ");
    $stmt->execute([$userId, $totalCompra, $metodo_pago]);

    // Obtener el último ID del pedido insertado
    $pedidoId = $conn->lastInsertId();

    // Insertar detalles en cliente_detalle
    $stmt = $conn->prepare("
        INSERT INTO cliente_detalle (user_id, nombre_cliente, producto_id, nombre_producto, precio_fijo, tipo_producto, tipo_compra, imagen, fecha_compra, pedido_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($productDetails as $product) {
        $precioFijo = ($product['tipo_compra'] === 'contado') ? $product['precio_contado'] : $product['precio_credito'];

        $stmt->execute([
            $userId,
            $nombre,
            $product['producto_id'],
            $product['nombre_producto'],
            $precioFijo,
            $product['tipo_producto'],
            $product['tipo_compra'],
            $product['imagen'],
            date('Y-m-d H:i:s'),
            $pedidoId // Agregar el ID del pedido
        ]);

        // Actualizar el inventario del producto
        $stmtUpdate = $conn->prepare("
            UPDATE productos 
            SET cantidad = cantidad - ? 
            WHERE id_producto = ? AND cantidad >= ?
        ");
        $stmtUpdate->execute([
            $product['cantidad'],
            $product['producto_id'],
            $product['cantidad']
        ]);

        if ($stmtUpdate->rowCount() == 0) {
            throw new Exception('Stock insuficiente para el producto: ' . $product['nombre_producto']);
        }
    }

    // Eliminar productos del carrito
    $stmt = $conn->prepare("DELETE FROM carrito WHERE user_id = ?");
    $stmt->execute([$userId]);

    $conn->commit();

} catch (PDOException $e) {
    $conn->rollBack();
    error_log('Error en la base de datos: ' . $e->getMessage(), 3, 'error_log.txt');
    die('Ocurrió un error con la base de datos. Por favor, inténtalo de nuevo más tarde.');
} catch (Exception $e) {
    $conn->rollBack();
    error_log('Error: ' . $e->getMessage(), 3, 'error_log.txt');
    die($e->getMessage());
}

// Preparar el mensaje para WhatsApp
$messageBody = "*Detalles de la Compra*\n\n";
$messageBody .= "*Información del Cliente*\n";
$messageBody .= "• *Nombre*: " . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . "\n";
$messageBody .= "• *Teléfono*: " . htmlspecialchars($telefono, ENT_QUOTES, 'UTF-8') . "\n";
$messageBody .= "• *Cédula*: " . htmlspecialchars($cedula, ENT_QUOTES, 'UTF-8') . "\n";
$messageBody .= "• *Correo*: " . htmlspecialchars($correo, ENT_QUOTES, 'UTF-8') . "\n";
$messageBody .= "• *Dirección*: " . htmlspecialchars($direccion, ENT_QUOTES, 'UTF-8') . "\n";
$messageBody .= "• *Método de Pago*: " . ucfirst($metodo_pago) . "\n\n";

$messageBody .= "*Detalles del Carrito*\n";
$total = 0;
$totalQuantity = 0;

foreach ($productDetails as $product) {
    $price = ($product['tipo_compra'] === 'contado') ? $product['precio_contado'] : $product['precio_credito'];

    $messageBody .= "• *Producto*: " . htmlspecialchars($product['nombre_producto'], ENT_QUOTES, 'UTF-8') . "\n";
    $messageBody .= "   - *Cantidad*: " . htmlspecialchars($product['cantidad'], ENT_QUOTES, 'UTF-8') . "\n";
    $messageBody .= "   - *Tipo de Compra*: " . ucfirst($product['tipo_compra']) . "\n";
    $messageBody .= "   - *Precio Unitario*: $" . number_format($price, 2) . "\n";
    $messageBody .= "   - *Subtotal*: $" . number_format($product['subtotal'], 2) . "\n\n";

    $total += $product['subtotal'];
    $totalQuantity += $product['cantidad'];
}

$messageBody .= "*Resumen de la Compra*\n";
$messageBody .= "• *Total*: $" . number_format($total, 2) . "\n";
$messageBody .= "• *Total de Productos*: " . $totalQuantity . "\n";

// Codificar el mensaje para URL
$messageBody = urlencode($messageBody);

// Crear el enlace de WhatsApp
$whatsappNumber = '+573182925046'; // Número en formato internacional
$whatsappMessage = "https://wa.me/{$whatsappNumber}?text=" . $messageBody;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745;
            font-size: 1.75rem;
            margin-bottom: 15px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-top: 20px;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        p {
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            color: #fff;
            background-color: #28a745;
        }
        .btn:hover {
            background-color: #218838;
        }
        .info {
            background-color: #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
        }
        .info p {
            margin: 5px 0;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 10px;
            }
            h1 {
                font-size: 1.5rem;
            }
            h2 {
                font-size: 1.25rem;
            }
            .btn {
                font-size: 0.875rem;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <a href="index.php">Volver</a>
    <div class="container">
        <h1>Compra Confirmada</h1>
        <p>Tu compra ha sido confirmada con éxito. Puedes contactar al representante para completar el pago utilizando el siguiente enlace:</p>
        <p style="text-align: center;">
            <a href="<?= $whatsappMessage ?>" class="btn" target="_blank">Contactar por WhatsApp</a>
        </p>

        <div class="info">
            <h2>Detalles de la Compra</h2>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Total de Productos:</strong> <?= $totalQuantity ?></p>
            <p><strong>Total a Pagar:</strong> $<?= number_format($total, 2) ?></p>
        </div>
    </div>
</body>
</html>
