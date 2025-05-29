<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

try {
    // Verificar que todos los campos requeridos estén presentes
    $campos_requeridos = ['id_producto', 'tipo_movimiento', 'cantidad', 'motivo'];
    foreach ($campos_requeridos as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            throw new Exception("El campo {$campo} es requerido");
        }
    }

    // Obtener datos del POST
    $id_producto = $_POST['id_producto'];
    $id_trabajador = $_POST['id_trabajador'] ?? 1; // Por defecto 1 si no se especifica
    $tipo_movimiento = $_POST['tipo_movimiento'];
    $cantidad = floatval($_POST['cantidad']);
    $motivo = $_POST['motivo'];

    // Validar cantidad
    if ($cantidad <= 0) {
        throw new Exception("La cantidad debe ser mayor a 0");
    }

    // Validar tipo de movimiento
    $tipos_validos = ['entrada', 'salida', 'transferencia'];
    if (!in_array($tipo_movimiento, $tipos_validos)) {
        throw new Exception("Tipo de movimiento no válido");
    }

    // Validar campos específicos según el tipo
    switch ($tipo_movimiento) {
        case 'entrada':
            if (!isset($_POST['proveedor']) || empty($_POST['proveedor'])) {
                throw new Exception("Debe seleccionar un proveedor");
            }
            if (!isset($_POST['monto']) || floatval($_POST['monto']) <= 0) {
                throw new Exception("El monto debe ser mayor a 0");
            }
            break;
        case 'salida':
            if (!isset($_POST['parcela']) || empty($_POST['parcela'])) {
                throw new Exception("Debe seleccionar una parcela");
            }
            if (!isset($_POST['trabajador']) || empty($_POST['trabajador'])) {
                throw new Exception("Debe seleccionar un trabajador");
            }
            break;
        case 'transferencia':
            if (!isset($_POST['destino']) || empty($_POST['destino'])) {
                throw new Exception("Debe seleccionar un destino");
            }
            break;
    }

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
    $stmt = $conn->prepare("INSERT INTO movimientos (id_producto, id_trabajador, tipo_movimiento, cantidad, motivo, fecha) 
                           VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$id_producto, $id_trabajador, $tipo_movimiento, $cantidad, $motivo]);

    // Actualizar el stock del producto
    $nuevo_stock = $producto['stock_actual'];
    if ($tipo_movimiento === 'entrada') {
        $nuevo_stock += $cantidad;
    } elseif ($tipo_movimiento === 'salida') {
        $nuevo_stock -= $cantidad;
    }
    // Para transferencia no modificamos el stock total

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