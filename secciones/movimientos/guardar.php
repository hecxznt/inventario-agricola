<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

try {
    // Obtener datos del POST
    $id_producto = $_POST['id_producto'];
    $id_trabajador = $_POST['id_trabajador'];
    $tipo_movimiento = $_POST['tipo_movimiento'];
    $cantidad = floatval($_POST['cantidad']);
    $motivo = $_POST['motivo'];

    // Validar que el producto existe
    $stmt = $conn->prepare("SELECT stock_actual FROM productos WHERE id_producto = ?");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        throw new Exception("El producto no existe");
    }

    // Validar stock para salidas
    if ($tipo_movimiento === 'salida') {
        if ($producto['stock_actual'] < $cantidad) {
            throw new Exception("No hay suficiente stock disponible. Stock actual: " . number_format($producto['stock_actual'], 2));
        }
    }

    // Iniciar transacción
    $conn->beginTransaction();

    // Insertar el movimiento
    $stmt = $conn->prepare("INSERT INTO movimientos (id_producto, id_trabajador, tipo_movimiento, cantidad, motivo) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_producto, $id_trabajador, $tipo_movimiento, $cantidad, $motivo]);

    // Actualizar el stock del producto
    $nuevo_stock = $producto['stock_actual'];
    if ($tipo_movimiento === 'entrada') {
        $nuevo_stock += $cantidad;
    } elseif ($tipo_movimiento === 'salida') {
        $nuevo_stock -= $cantidad;
    }

    $stmt = $conn->prepare("UPDATE productos SET stock_actual = ? WHERE id_producto = ?");
    $stmt->execute([$nuevo_stock, $id_producto]);

    // Confirmar transacción
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Movimiento registrado correctamente',
        'nuevo_stock' => $nuevo_stock
    ]);

} catch (Exception $e) {
    // Revertir transacción si hubo error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 